<?php

namespace App\Http\Controllers;

use App\Models\UnmatchedCar;
use App\Models\Car;
use App\Models\Showroom;
use Illuminate\Http\Request;

class CarReviewController extends Controller
{
    // Tampilkan daftar data gantung
    public function index()
    {
        $unmatchedCars = UnmatchedCar::latest()->paginate(10);
        $showrooms = Showroom::all(); // Untuk pilihan dropdown manual

        // Ubah dari 'admin.cars.review' menjadi 'cars.review'
        return view('cars.review', compact('unmatchedCars', 'showrooms'));
    }

    // Aksi Admin: Tautkan Showroom secara manual lalu pindahkan ke tabel utama
    public function approve(Request $request, $id)
    {
        $request->validate([
            'showroom_id' => 'required|exists:showrooms,id'
        ]);

        $unmatched = UnmatchedCar::findOrFail($id);
        $showroom = Showroom::findOrFail($request->showroom_id);

        // Pindahkan ke tabel utama 'cars'
        Car::updateOrCreate(
            ['no_polisi' => $unmatched->no_polisi],
            [
                'no_cif'       => $showroom->cno, // Perbaiki CIF sesuai showroom yang dipilih
                'nama_merk'    => $unmatched->nama_merk,
                'tipe_kend'    => $unmatched->tipe_kend,
                'warna_kend'   => $unmatched->warna_kend,
                'jenis_kend'   => $unmatched->jenis_kend,
                'transmisi'    => $unmatched->transmisi,
                'tahun_buat'   => $unmatched->tahun_buat,
                'foto_depan'   => $unmatched->foto_depan,
                'foto_belakang'=> $unmatched->foto_belakang,
                'foto_samping' => $unmatched->foto_samping,
            ]
        );

        // Hapus dari tabel staging
        $unmatched->delete();

        return redirect()->back()->with('success', 'Data unit berhasil ditautkan dan dipindahkan ke katalog utama!');
    }

    // Aksi Admin: Hapus data jika sampah / tidak valid
    public function destroy($id)
    {
        UnmatchedCar::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus dari antrean review.');
    }
}