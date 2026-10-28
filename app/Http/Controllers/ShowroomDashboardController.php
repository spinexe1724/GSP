<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class ShowroomDashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data user yang sedang login menggunakan Auth standar
        $user = Auth::user(); 
        
        // 2. Ambil data showroom aslinya berdasarkan showroom_id
        $showroom = \App\Models\Showroom::find($user->showroom_id);

        // 3. Ambil nomor cno/cif (Asumsi kolom di tabel showrooms bernama 'cno')
        $cnoShowroom = $showroom->cno; 

        // 4. Hitung statistik
        $totalCars = Car::where('no_cif', $cnoShowroom)->count();
        
        $fotoLengkap = Car::where('no_cif', $cnoShowroom)
                          ->whereNotNull('foto_depan')
                          ->where('foto_depan', '!=', '')
                          ->count();
                          
        $perluFoto = $totalCars - $fotoLengkap;

        $cars = Car::where('no_cif', $cnoShowroom)
                   ->latest()
                   ->paginate(10);

        // 5. Kirim juga variabel $showroom ke view agar bisa dipakai
        return view('showrooms.dashboard', compact('totalCars', 'fotoLengkap', 'perluFoto', 'cars', 'showroom'));
    }

    public function editFoto($id)
    {
$user = Auth::user();
        
        // Cari relasi showroom-nya
        $showroom = \App\Models\Showroom::find($user->showroom_id);
        
        // Cegah error jika data showroom tidak sengaja terhapus/hilang
        if (!$showroom) {
            abort(403, 'Data Showroom tidak ditemukan untuk akun ini.');
        }

        $cnoShowroom = $showroom->cno;

        // Cari data mobil yang sesuai
        $car = Car::where('id', $id)->where('no_cif', $cnoShowroom)->firstOrFail();

        return view('showrooms.cars.edit-foto', compact('car'));
    }

    public function updateFoto(Request $request, $id)
    {
        // 1. Ambil data user dari tabel users (bawaan Laravel)
        $user = Auth::user();
        
        // 2. Ambil data showroom berdasarkan relasi showroom_id
        $showroom = \App\Models\Showroom::find($user->showroom_id);
        
        // Proteksi jika data showroom tidak ditemukan
        if (!$showroom) {
            abort(403, 'Data Showroom tidak ditemukan untuk akun ini.');
        }

        // 3. Ambil nomor cno
        $cnoShowroom = $showroom->cno;

        // 4. Cari data mobil berdasarkan ID dan cno showroom
        $car = Car::where('id', $id)->where('no_cif', $cnoShowroom)->firstOrFail();

        // 5. Validasi file dan input harga
        $request->validate([
            'harga'         => 'nullable|numeric|min:0', 
            'foto_depan'    => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'foto_belakang' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'foto_samping'  => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'foto_odometer' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'foto_lainnya_1' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'foto_lainnya_2' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'foto_lainnya_3' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            
        ]);

        // 6. Simpan harga baru
        $car->harga = $request->harga;

        // 7. Proses upload masing-masing foto
        $fields = ['foto_depan', 'foto_belakang', 'foto_samping', 'foto_odometer','foto_lainnya_1','foto_lainnya_2','foto_lainnya_3',];
        $destinationPath = public_path('uploads/cars');

        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                
                // Format penamaan file yang rapi
                $filename = time() . '_' . $car->id . '_' . $field . '.' . $file->getClientOriginalExtension();

                // Hapus foto lama jika ada
                if ($car->$field) {
                    $oldFilename = str_replace('uploads/cars/', '', $car->$field);
                    if (\Illuminate\Support\Facades\File::exists($destinationPath . '/' . $oldFilename)) {
                        \Illuminate\Support\Facades\File::delete($destinationPath . '/' . $oldFilename);
                    }
                }

                // Pindahkan file baru ke folder tujuan
                $file->move($destinationPath, $filename);
                $car->$field = 'uploads/cars/' . $filename;
            }
        }

        // 8. Simpan ke database
        $car->save();

        // 9. Redirect kembali ke dashboard dengan pesan sukses
        return redirect()->route('showrooms.dashboard')->with('success', 'Detail unit dan foto berhasil diperbarui!');
    }
    public function edit_profile()
    {
      $user = auth()->user();
        
        // Ambil data showroom milik user ini
        $showroom = \App\Models\Showroom::find($user->showroom_id);

        // Kirimkan $user dan $showroom ke view
        return view('showrooms.settings', compact('user', 'showroom'));
    }
    
   public function update_profile(Request $request)
    {
        // 1. Ambil data user yang sedang login
        $user = Auth::user();
        
        // 2. Validasi input dari form
        $request->validate([
            'nopic'    => 'required|string|max:20', // nopic = Nomor HP Penanggung Jawab
            'password' => 'nullable|string|min:6|confirmed', // Opsional, hanya jika ingin ganti password
        ]);

        // 3. Update Nomor HP di tabel showrooms (Kolom nopic)
        $showroom = \App\Models\Showroom::find($user->showroom_id);
        if ($showroom) {
            $showroom->nopic = $request->nopic;
            $showroom->save();
        }

        // 4. Update Password di tabel users (jika diisi)
        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            $user->save();
        }

        // 5. Kembalikan ke halaman profil dengan pesan sukses
        return redirect()->back()->with('success', 'Profil dan informasi kontak berhasil diperbarui!');
    }
}