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
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'photos' => 'required|array'
        ]);

        $nopol_detected = urldecode($id);
        $car = Car::findOrFail($request->car_id);

        // Looping data foto yang dikirim dari form
        foreach ($request->photos as $photoId => $data) {
            $slot = $data['slot']; // Berisi: ignore, foto_depan, foto_belakang, dll

            if ($slot !== 'ignore') {
                // Cari foto di tabel temporary
                $tempPhoto = UnmatchedPhoto::find($photoId);
                
                if ($tempPhoto) {
                    // Masukkan path foto ke kolom slot yang dipilih di tabel cars
                    // Misalnya: $car->foto_depan = $tempPhoto->file_path;
                    $car->{$slot} = $tempPhoto->file_path;
                    
                    // (Opsional) Pindahkan file fisik dari folder temp ke folder permanen di sini jika diperlukan
                }
            }
        }

        // Simpan perubahan ke tabel cars
        $car->save();

        // Hapus data foto di tabel temporary (PhotoReview) untuk Nopol ini agar hilang dari daftar antrean
        UnmatchedPhoto::where('nopol_detected', $nopol_detected)->delete();

        // Redirect kembali ke halaman utama list nopol
        return redirect()->route('admin.cars.photo_review.index')
                         ->with('success', "Foto untuk antrean {$nopol_detected} berhasil dipetakan ke unit {$car->no_polisi}.");
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

return redirect()->route('admin.cars.photo_review.index')->with('success', 'Semua data dihapus');

}
public function detail($id)
{
    // 1. Decode ID (nama folder / nopol) dari URL
    $nopol_detected = urldecode($id);

    // 2. Ambil foto berdasarkan nama folder. 
    // PENTING: Sesuaikan 'folder_name' dengan nama kolom asli di database Anda! 
    // (Bisa jadi namanya 'folder', 'nama_folder', atau 'no_polisi')
    $photos = \App\Models\UnmatchedPhoto::where('nopol_detected', $nopol_detected)->get();

    // 3. VALIDASI PINTAR: Jika foto sudah kosong (sudah diproses semua/dihapus dari database), 
    // langsung kembalikan ke halaman list agar tidak menampilkan halaman kosong.
    if ($photos->isEmpty()) {
        return redirect()->route('admin.cars.photo_review.index')
                         ->with('info', "Semua antrean foto untuk folder {$nopol_detected} sudah selesai diproses.");
    }

    // 4. Ambil daftar mobil untuk dropdown pilihan
    $carsNeedingPhotos = \App\Models\Car::select('id', 'no_polisi', 'nama_merk', 'tipe_kend')
        ->orderBy('no_polisi', 'asc')
        ->get();

    // 5. Tampilkan ke view
    // (Pastikan variabel yang dilempar sesuai dengan yang dipanggil di file blade Anda)
    return view('cars.photo_review_detail', compact('nopol_detected', 'photos', 'carsNeedingPhotos'));
}


}