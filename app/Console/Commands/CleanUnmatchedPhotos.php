<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UnmatchedPhoto;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CleanUnmatchedPhotos extends Command
{
    // Nama command yang akan dipanggil
    protected $signature = 'photos:clean-unmatched';

    // Deskripsi command
    protected $description = 'Menghapus data dan file fisik foto review (UnmatchedPhoto)';

    public function handle()
    {
        $this->info('Memulai pembersihan Unmatched Photos...');
        
        // Opsional: Jika ingin menghapus HANYA yang sudah berumur lebih dari 6 jam:
        // $photos = UnmatchedPhoto::where('created_at', '<=', now()->subHours(6))->get();
        
        // Jika ingin menghapus SEMUA data di tabel tersebut:
        $photos = UnmatchedPhoto::all();
        $count = 0;

        foreach ($photos as $photo) {
            $physicalPath = public_path($photo->file_path);

            if (File::exists($physicalPath)) {
                File::delete($physicalPath);
            }

            $photo->delete();
            $count++;
        }

        $pesan = "Pembersihan otomatis selesai. {$count} foto dihapus.";
        Log::info($pesan);
        $this->info($pesan);
    }
}