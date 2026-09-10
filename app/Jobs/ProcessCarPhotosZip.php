<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Car;
use App\Models\UnmatchedPhoto;
use Illuminate\Support\Facades\File;

class ProcessCarPhotosZip implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fullZipPath;

    // Atur timeout job hingga 30 menit khusus file besar
    public $timeout = 3000;
    public $tries = 1;

    public function __construct($fullZipPath)
    {
        $this->fullZipPath = $fullZipPath;
    }

    public function handle()
    {
        // Set limit server khusus background process
        ini_set('memory_limit', '2048M');

        try {
           $zip = new \ZipArchive;
if ($zip->open($this->fullZipPath) === TRUE) {
    $extractPath = storage_path('app/temp_extracted_' . time());
    $zip->extractTo($extractPath);
    $zip->close();
                $destinationDir = public_path('uploads/cars');
                if (!file_exists($destinationDir)) {
                    mkdir($destinationDir, 0777, true);
                }

                // --- LOGIKA UTAMA SAMA PERSIS SEPERTI SEBELUMNYA ---
                $iterator = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($extractPath, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::SELF_FIRST
                );

                $groupedByFolder = [];

                foreach ($iterator as $fileInfo) {
                    if ($fileInfo->isFile()) {
                        $fileName = $fileInfo->getFilename();
                        $fileNameLower = strtolower($fileName);

                        if (in_array($fileNameLower, ['.ds_store', 'thumbs.db', 'desktop.ini']) || str_starts_with($fileName, '.')) {
                            continue;
                        }

                        $folderPath = $fileInfo->getPath();
                        $folderName = basename($folderPath);

                        if ($folderPath === $extractPath) {
                            continue;
                        }

                        $groupedByFolder[$folderName]['path'] = $folderPath;
                        $groupedByFolder[$folderName]['files'][] = [
                            'name'      => $fileName,
                            'name_lower'=> $fileNameLower,
                            'pathname'  => $fileInfo->getPathname()
                        ];
                    }
                }

                $matchedCount = 0;
                $reviewCount = 0;

                foreach ($groupedByFolder as $rawFolderName => $group) {
                    if (preg_match('/([A-Z]{1,2}\s*\d{1,4}\s*[A-Z]{0,3})/i', $rawFolderName, $nopolMatches)) {
                        $nopolClean = strtoupper(preg_replace('/[^A-Z0-9]/', '', $nopolMatches[1]));
                    } else {
                        $nopolClean = strtoupper(preg_replace('/[^A-Z0-9]/', '', $rawFolderName));
                    }

                    $car = Car::whereRaw("UPPER(REPLACE(no_polisi, ' ', '')) = ?", [$nopolClean])->first();

                    $hasValidSequenceMarker = false;
                    foreach ($group['files'] as $f) {
                        if (preg_match('/_1\.(jpg|jpeg|png)/i', $f['name'])) {
                            $hasValidSequenceMarker = true;
                            break;
                        }
                    }

                    if ($hasValidSequenceMarker && $car) {
                        $hasAssignedPhoto = false;

                        foreach ($group['files'] as $f) {
                            $originalName = $f['name'];
                            $fNameLower = $f['name_lower'];

                            $uniqueFileName = time() . '_' . uniqid() . '_' . $originalName;
                            $targetRelativePath = 'uploads/cars/' . $uniqueFileName;
                            $targetPhysicalPath = public_path($targetRelativePath);

                            if (preg_match('/_2\.(jpg|jpeg|png)/i', $fNameLower)) {
                                copy($f['pathname'], $targetPhysicalPath);
                                $car->foto_depan = $targetRelativePath;
                                $matchedCount++;
                                $hasAssignedPhoto = true;
                            } elseif (preg_match('/_3\.(jpg|jpeg|png)/i', $fNameLower)) {
                                copy($f['pathname'], $targetPhysicalPath);
                                $car->foto_belakang = $targetRelativePath;
                                $matchedCount++;
                                $hasAssignedPhoto = true;
                            } elseif (preg_match('/_4\.(jpg|jpeg|png)/i', $fNameLower)) {
                                copy($f['pathname'], $targetPhysicalPath);
                                $car->foto_samping = $targetRelativePath;
                                $matchedCount++;
                                $hasAssignedPhoto = true;
                            } else {
                                // File sisa otomatis dibuang/diabaikan sesuai logika Anda
                            }
                        }

                        if ($hasAssignedPhoto) {
                            $car->save();
                        }
                        
                    } else {
                        foreach ($group['files'] as $f) {
                            $originalName = $f['name'];
                            $uniqueFileName = time() . '_' . uniqid() . '_' . $originalName;
                            $targetRelativePath = 'uploads/cars/' . $uniqueFileName;
                            $targetPhysicalPath = public_path($targetRelativePath);

                            copy($f['pathname'], $targetPhysicalPath);

                            UnmatchedPhoto::create([
                                'file_name'      => $originalName,
                                'nopol_detected' => $rawFolderName,
                                'slot_detected'  => '-',
                                'file_path'      => $targetRelativePath,
                                'reason'         => 'Folder tidak berurutan (tidak ada penanda _1) atau unit mobil tidak terdaftar.'
                            ]);
                            $reviewCount++;
                        }
                    }
                }

                // Bersihkan folder ekstraksi sementara
                File::deleteDirectory($extractPath);
            }

            // Hapus file ZIP sumber setelah selesai diproses
            if (file_exists($this->fullZipPath)) {
                @unlink($this->fullZipPath);
            }

        } catch (\Exception $e) {
            // LEMPAR EXCEPTION AGAR TERCETAK DI TERMINAL WORKER
            throw $e; 
        }
    }
}