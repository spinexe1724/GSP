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
    protected $extractPath;
    protected $chunkFolder;
    public $timeout = 3000;
    public $tries = 1;

    public function __construct($fullZipPath, $extractPath = null, $chunkFolder = null)
    {
        $this->fullZipPath = $fullZipPath;
        $this->extractPath = $extractPath;
        $this->chunkFolder = $chunkFolder;
    }

    public function handle()
    {
        ini_set('memory_limit', '2048M');

        try {
            $zip = new \ZipArchive;
            
            if ($zip->open($this->fullZipPath) === TRUE) {
                $this->extractPath = storage_path('app/temp_extracted_' . time()); 
                $zip->extractTo($this->extractPath);
                $zip->close();
                
                $iterator = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($this->extractPath, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::SELF_FIRST
                );

                $groupedByFolder = [];

                foreach ($iterator as $fileInfo) {
                    if ($fileInfo->isFile()) {
                        $fileName = $fileInfo->getFilename();
                        $fileNameLower = strtolower($fileName);
                        $folderPath = $fileInfo->getPath();

                        // Blokir folder bayangan dari Mac
                        if (str_contains(strtoupper($folderPath), '__MACOSX')) {
                            continue;
                        }

                        // Blokir file sistem tersembunyi
                        if (in_array($fileNameLower, ['.ds_store', 'thumbs.db', 'desktop.ini']) || str_starts_with($fileName, '.')) {
                            continue;
                        }

                        // ==========================================================
                        // TAMBAHAN BARU: Tolak semua file yang bukan gambar
                        // ==========================================================
                        $extension = pathinfo($fileNameLower, PATHINFO_EXTENSION);
                        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                        
                        if (!in_array($extension, $allowedExtensions)) {
                            continue; // Abaikan file jika bukan gambar
                        }

                        $folderName = basename($folderPath);

                        if ($folderPath === $this->extractPath) {
                            continue;
                        }

                        $groupedByFolder[$folderName]['path'] = $folderPath;
                        $groupedByFolder[$folderName]['files'][] = [
                            'name'       => $fileName,
                            'name_lower' => $fileNameLower,
                            'pathname'   => $fileInfo->getPathname()
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
                            } elseif (preg_match('/_1\.(jpg|jpeg|png|webp)/i', $fNameLower)) {
                                copy($f['pathname'], $targetPhysicalPath);
                                $car->foto_odometer = $targetRelativePath;
                                $matchedCount++;
                                $hasAssignedPhoto = true;
                            }
                        }

                        if ($hasAssignedPhoto) {
                            $car->save();
                        }
                        
                    } else {
                        // FOTO UNMATCHED (Cek Duplikat dengan LIKE)
                        $unmatchedDir = public_path('uploads/unmatched');
                        if (!file_exists($unmatchedDir)) {
                            mkdir($unmatchedDir, 0777, true);
                        }

                        foreach ($group['files'] as $f) {
                            $originalName = $f['name'];
                            
                            // Cek duplikasi berdasar akhiran nama asli
                            $isDuplicate = UnmatchedPhoto::where('nopol_detected', $rawFolderName)
                                ->where('file_name', 'LIKE', '%_' . $originalName)
                                ->exists();

                            if (!$isDuplicate) {
                                $uniqueFileName = time() . '_' . uniqid() . '_' . $originalName;
                                $targetRelativePath = 'uploads/unmatched/' . $uniqueFileName;
                                $targetPhysicalPath = public_path($targetRelativePath);

                                copy($f['pathname'], $targetPhysicalPath);

                                UnmatchedPhoto::create([
                                    'file_name'      => $uniqueFileName, 
                                    'nopol_detected' => $rawFolderName,
                                    'slot_detected'  => '-',
                                    'file_path'      => $targetRelativePath, 
                                    'reason'         => 'Folder tidak berurutan (tidak ada penanda _1) atau unit mobil tidak terdaftar.'
                                ]);
                                $reviewCount++;
                            }
                        }
                    }
                }
                
                File::deleteDirectory($this->extractPath);
            }

            if (file_exists($this->fullZipPath)) {
                @unlink($this->fullZipPath);
            }
            \Illuminate\Support\Facades\Cache::put('zip_process_status', 'completed', now()->addMinutes(10));

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Cache::put('zip_process_status', 'error', now()->addMinutes(10));
            throw $e; 
        } finally {
            if ($this->fullZipPath && File::exists($this->fullZipPath)) {
                File::delete($this->fullZipPath);
            }

            if ($this->extractPath && File::exists($this->extractPath)) {
                File::deleteDirectory($this->extractPath);
            }

            if ($this->chunkFolder && File::exists($this->chunkFolder)) {
                File::deleteDirectory($this->chunkFolder);
            }
        }
    }
}