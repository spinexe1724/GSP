<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Car;
use App\Models\UnmatchedPhoto; // Pastikan model ini di-import

class InjectFotoMobil extends Command
{
    protected $signature = 'foto:inject';
    protected $description = 'Inject data 10GB foto mentah ke database mengikuti logika ZIP (Berdasarkan Folder & Penanda _1, _2, _3, _4)';

    public function handle()
    {
        ini_set('memory_limit', '2048M');

        $sourceDir = public_path('uploads/staging_photos');
        $carsDir = public_path('uploads/cars');
        $unmatchedDir = public_path('uploads/unmatched');

        if (!File::exists($carsDir)) File::makeDirectory($carsDir, 0755, true);
        if (!File::exists($unmatchedDir)) File::makeDirectory($unmatchedDir, 0755, true);

        if (!File::exists($sourceDir)) {
            $this->error("Folder staging_photos tidak ditemukan!");
            return;
        }

        $this->info("Memindai seluruh file dan folder di staging_photos...");

        // 1. Ambil semua file secara rekursif
        $allFiles = File::allFiles($sourceDir);
        
        if (count($allFiles) === 0) {
            $this->info("Tidak ada file foto ditemukan di staging_photos.");
            return;
        }

        $groupedByFolder = [];

        // 2. KELOMPOKKAN FILE BERDASARKAN FOLDER (Sesuai Logika ZIP Anda)
        foreach ($allFiles as $file) {
            $fileName = $file->getFilename();
            $fileNameLower = strtolower($fileName);
            $folderPath = $file->getPath();
            
            // Blokir folder bayangan dari Mac
            if (str_contains(strtoupper($folderPath), '__MACOSX')) {
                continue;
            }

            // Blokir file sistem tersembunyi
            if (in_array($fileNameLower, ['.ds_store', 'thumbs.db', 'desktop.ini']) || str_starts_with($fileName, '.')) {
                continue;
            }

            // Tolak semua file yang bukan gambar
            $extension = $file->getExtension();
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'jfif', 'webp'];
            if (!in_array(strtolower($extension), $allowedExtensions)) {
                continue; 
            }

            $folderName = basename($folderPath);

            // Jangan proses file yang berada persis di root staging_photos (harus di dalam folder nopol)
            if ($folderPath === $sourceDir) {
                continue;
            }

            $groupedByFolder[$folderName]['path'] = $folderPath;
            $groupedByFolder[$folderName]['files'][] = [
                'name'       => $fileName,
                'name_lower' => $fileNameLower,
                'pathname'   => $file->getPathname()
            ];
        }

        $matchedCount = 0;
        $reviewCount = 0;

        $this->info("Ditemukan " . count($groupedByFolder) . " folder kendaraan. Memulai penyortiran...");

        // 3. PROSES SETIAP FOLDER
        foreach ($groupedByFolder as $rawFolderName => $group) {
            // Ekstrak Nopol dari Nama Folder
            if (preg_match('/([A-Z]{1,2}\s*\d{1,4}\s*[A-Z]{0,3})/i', $rawFolderName, $nopolMatches)) {
                $nopolClean = strtoupper(preg_replace('/[^A-Z0-9]/', '', $nopolMatches[1]));
            } else {
                $nopolClean = strtoupper(preg_replace('/[^A-Z0-9]/', '', $rawFolderName));
            }

            $car = Car::whereRaw("UPPER(REPLACE(no_polisi, ' ', '')) = ?", [$nopolClean])->first();

            // Cek penanda urutan (_1)
            $hasValidSequenceMarker = false;
            foreach ($group['files'] as $f) {
                if (preg_match('/_1\.(jpg|jpeg|png|webp|jfif)/i', $f['name'])) {
                    $hasValidSequenceMarker = true;
                    break;
                }
            }

            if ($hasValidSequenceMarker && $car) {
                // JIKA COCOK (MATCH)
                $hasAssignedPhoto = false;

                foreach ($group['files'] as $f) {
                    $originalName = $f['name'];
                    $fNameLower = $f['name_lower'];

                    $uniqueFileName = time() . '_' . uniqid() . '_' . $originalName;
                    $targetRelativePath = 'uploads/cars/' . $uniqueFileName;
                    $targetPhysicalPath = public_path($targetRelativePath);

                    // Pemetaan berdasarkan akhiran angka (Sesuai Logika Anda)
                    if (preg_match('/_2\.(jpg|jpeg|png|webp|jfif)/i', $fNameLower)) {
                        File::move($f['pathname'], $targetPhysicalPath);
                        $car->foto_depan = $targetRelativePath;
                        $matchedCount++;
                        $hasAssignedPhoto = true;
                    } elseif (preg_match('/_3\.(jpg|jpeg|png|webp|jfif)/i', $fNameLower)) {
                        File::move($f['pathname'], $targetPhysicalPath);
                        $car->foto_belakang = $targetRelativePath;
                        $matchedCount++;
                        $hasAssignedPhoto = true;
                    } elseif (preg_match('/_4\.(jpg|jpeg|png|webp|jfif)/i', $fNameLower)) {
                        File::move($f['pathname'], $targetPhysicalPath);
                        $car->foto_samping = $targetRelativePath;
                        $matchedCount++;
                        $hasAssignedPhoto = true;
                    } elseif (preg_match('/_1\.(jpg|jpeg|png|webp|jfif)/i', $fNameLower)) {
                        File::move($f['pathname'], $targetPhysicalPath);
                        $car->foto_odometer = $targetRelativePath;
                        $matchedCount++;
                        $hasAssignedPhoto = true;
                    } else {
                        // File dalam folder valid, tetapi bukan _1, _2, _3, _4. Pindahkan agar folder sumber kosong.
                        File::move($f['pathname'], public_path('uploads/cars/etc_' . $uniqueFileName));
                    }
                }

                if ($hasAssignedPhoto) {
                    $car->save();
                    $this->line("✅ MATCH: {$rawFolderName} -> Nopol: {$nopolClean}");
                }
                
            } else {
                // JIKA TIDAK COCOK / TIDAK ADA _1 (UNMATCHED)
                foreach ($group['files'] as $f) {
                    $originalName = $f['name'];
                    
                    // Cek duplikasi di DB
                    $isDuplicate = UnmatchedPhoto::where('nopol_detected', $rawFolderName)
                        ->where('file_name', 'LIKE', '%_' . $originalName)
                        ->exists();

                    if (!$isDuplicate) {
                        $uniqueFileName = time() . '_' . uniqid() . '_' . $originalName;
                        $targetRelativePath = 'uploads/unmatched/' . $uniqueFileName;
                        $targetPhysicalPath = public_path($targetRelativePath);

                        File::move($f['pathname'], $targetPhysicalPath);

                        UnmatchedPhoto::create([
                            'file_name'      => $uniqueFileName, 
                            'nopol_detected' => $rawFolderName,
                            'slot_detected'  => '-',
                            'file_path'      => $targetRelativePath, 
                            'reason'         => 'Folder tidak berurutan (tidak ada penanda _1) atau unit mobil tidak terdaftar.'
                        ]);
                        $reviewCount++;
                    } else {
                        // Jika duplikat, cukup hapus file fisik agar tidak nyangkut
                        File::delete($f['pathname']);
                    }
                }
                $this->warn("❌ UNMATCHED: {$rawFolderName}");
            }
        }

        // 4. CLEANUP (Menghapus folder kosong di staging_photos)
        $this->info("Membersihkan folder-folder kosong di staging_photos...");
        $directories = File::directories($sourceDir);
        foreach ($directories as $directory) {
            if (count(File::allFiles($directory)) === 0) {
                File::deleteDirectory($directory);
            }
        }

        $this->newLine();
        $this->info("=== HASIL AKHIR INJECT ===");
        $this->info("Berhasil (Match)  : {$matchedCount} foto di-update ke tabel Cars.");
        $this->info("Gagal (Unmatched) : {$reviewCount} foto masuk ke tabel UnmatchedPhoto.");
    }
}