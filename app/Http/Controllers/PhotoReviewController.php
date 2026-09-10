<?php

namespace App\Http\Controllers;

use App\Models\UnmatchedPhoto;
use App\Models\UnmatchedCar;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PhotoReviewController extends Controller
{
    // Tampilkan daftar foto gantung / tidak berurutan
    public function index()
    {
       $allPhotos = \App\Models\UnmatchedPhoto::latest()
                        ->get()
                        ->groupBy('nopol_detected');

        // 2. Terapkan filter (Hanya sisakan folder yang mengandung unsur Nopol)
        $groupedPhotos = $allPhotos->filter(function ($photos, $folderName) {
            if (strtoupper($folderName) === 'TIDAK TERBACA') {
                return false;
            }
            return preg_match('/[A-Z]{1,2}\s*\d{1,4}\s*[A-Z]{0,3}/i', $folderName);
        });

        // 3. Ambil data mobil yang kekurangan foto untuk dropdown
        $carsNeedingPhotos = \App\Models\Car::whereNull('foto_depan')
                                ->orWhereNull('foto_belakang')
                                ->orWhereNull('foto_samping')
                                ->orderBy('no_polisi', 'asc')
                                ->get();

        // 4. TAMBAHKAN INI: Ambil data mobil yang CIF-nya tidak cocok (jika Blade Anda membutuhkannya)
$unmatchedCars = \App\Models\UnmatchedCar::latest()->paginate(10);
        // 5. Kirim SEMUA variabel ke View (termasuk unmatchedCars)
        return view('cars.photo_review', compact('groupedPhotos', 'carsNeedingPhotos', 'unmatchedCars'));
    }

    // Aksi Admin: Tautkan foto secara manual ke Nopol / Mobil yang benar
   public function assign(Request $request, $id)
    {
        // 1. Validasi input
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'photos' => 'required|array'
        ], [
            'car_id.required' => 'Pilih unit mobil terlebih dahulu dari dropdown.'
        ]);

        // 2. Cari unit mobil berdasarkan pilihan dropdown
        $car = \App\Models\Car::findOrFail($request->car_id);
        $assignedAny = false;
        $processedPhotoIds = [];

        // 3. Looping data array photos yang dikirim dari form
        foreach ($request->photos as $photoData) {
            // Pastikan data slot dipilih dan bukan 'ignore'
            if (isset($photoData['id']) && isset($photoData['slot']) && $photoData['slot'] !== 'ignore') {
                
                $unmatchedPhoto = \App\Models\UnmatchedPhoto::find($photoData['id']);
                
                if ($unmatchedPhoto) {
                    $slot = $photoData['slot']; // Berisi 'foto_depan', 'foto_belakang', atau 'foto_samping'
                    
                    if (in_array($slot, ['foto_depan', 'foto_belakang', 'foto_samping'])) {
                        // Masukkan path file ke kolom database mobil
                        $car->{$slot} = $unmatchedPhoto->file_path;
                        $assignedAny = true;
                        
                        // Kumpulkan ID foto yang berhasil dipasang
                        $processedPhotoIds[] = $unmatchedPhoto->id;
                    }
                }
            }
        }

        // 4. Jika ada foto yang dipilih, simpan mobil dan hapus foto dari tabel review
        if ($assignedAny) {
            $car->save();
            
            if (!empty($processedPhotoIds)) {
                \App\Models\UnmatchedPhoto::whereIn('id', $processedPhotoIds)->delete();
            }
            
            return redirect()->back()->with('success', "Foto berhasil dipasangkan ke unit mobil secara manual!");
        }

        return redirect()->back()->with('error', 'Tidak ada foto yang dipilih untuk dipasangkan. Ubah status minimal satu foto menjadi Depan/Belakang/Samping.');
    }

    public function clearUnmatchedPhotos()
{
    // Ambil semua data foto yang tidak cocok
    $unmatchedPhotos = UnmatchedPhoto::all();
    $count = 0;

    foreach ($unmatchedPhotos as $photo) {
        $physicalPath = public_path($photo->file_path);

        // Hapus file fisik dari folder public/uploads/cars/
        if (File::exists($physicalPath)) {
            File::delete($physicalPath);
        }

        // Hapus data dari database
        $photo->delete();
        $count++;
    }

    return back()->with('success', "Berhasil menghapus {$count} foto review beserta file fisiknya.");
}
}