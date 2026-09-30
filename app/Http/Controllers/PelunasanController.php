<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car; // Sesuaikan dengan Model unit mobil Anda
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Rap2hpoutre\FastExcel\FastExcel;

class PelunasanController extends Controller
{
    public function importPelunasan(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            $deletedCount = 0;

            // FastExcel mengembalikan Collection dari setiap baris data (menggunakan key header secara otomatis)
           (new FastExcel)->import($request->file('file'), function ($line) use (&$deletedCount) {
    
    // Cari key kolom no_polisi (case-insensitive)
    $nopolRaw = null;
    foreach ($line as $key => $value) {
        $cleanKey = strtolower(trim(str_replace(' ', '_', $key)));
        if ($cleanKey === 'no_polisi' || $cleanKey === 'nopol') {
            $nopolRaw = trim($value);
            break;
        }
    }

    if (empty($nopolRaw)) {
        return; 
    }

    // Normalisasi Nopol
    $nopolClean = str_replace(' ', '', strtoupper($nopolRaw));

    // PERBAIKAN DI SINI: Ubah 'nopol' menjadi 'no_polisi' sesuai nama kolom tabel database
    $cars = Car::whereRaw("REPLACE(UPPER(no_polisi), ' ', '') = ?", [$nopolClean])->get();

    foreach ($cars as $car) {
        // A. Hapus berkas foto dari storage
        if (!empty($car->foto)) {
            if (Storage::disk('public')->exists($car->foto)) {
                Storage::disk('public')->delete($car->foto);
            }

            $pathPublic = public_path('uploads/cars/' . $car->foto);
            if (File::exists($pathPublic)) {
                File::delete($pathPublic);
            }
        }

        // B. Hapus record dari database
        $car->delete();
        $deletedCount++;
    }
});

            return redirect()->route('admin.upload-data', [
                'imported' => 'pelunasan_success',
                'count' => $deletedCount
            ]);

        } catch (\Exception $e) {
            return redirect()->route('admin.upload-data', [
                'imported' => 'error',
                'msg' => $e->getMessage()
            ]);
        }Finally {
            // 3. HAPUS FILE EXCEL SEMENTARA SECARA OTOMATIS DI SINI
            // Berjalan otomatis baik saat sukses maupun saat terjadi error di tengah jalan
            if ($filePath && File::exists($filePath)) {
                File::delete($filePath);
            }
        }
    }
}