<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File; // <-- TAMBAHKAN BARIS INI DI SINI!
class ShowroomDashboardController extends Controller
{
public function index()
{
    // 1. Ambil nilai 'cno' dari showroom yang sedang login
    $cnoShowroom = Auth::guard('showroom')->user()->cno; 

    // 2. Cocokkan 'cno' tersebut dengan kolom 'no_cif' di tabel cars
    $totalCars = Car::where('no_cif', $cnoShowroom)->count();
    
    $fotoLengkap = Car::where('no_cif', $cnoShowroom)
                      ->whereNotNull('foto_depan')
                      ->where('foto_depan', '!=', '')
                      ->count();
                      
    $perluFoto = $totalCars - $fotoLengkap;

    $cars = Car::where('no_cif', $cnoShowroom)
               ->latest()
               ->paginate(10);

    return view('showrooms.dashboard', compact('totalCars', 'fotoLengkap', 'perluFoto', 'cars'));
}
public function editFoto($id)
    {
        $cnoShowroom = Auth::guard('showroom')->user()->cno;
        
        // Pastikan mobil milik showroom yang sedang login
        $car = Car::where('id', $id)->where('no_cif', $cnoShowroom)->firstOrFail();

        return view('showrooms.cars.edit-foto', compact('car'));
    }

    // --- TAMBAHKAN METHOD INI UNTUK MENYIMPAN FOTO ---
public function updateFoto(Request $request, $id)
{
    $cnoShowroom = Auth::guard('showroom')->user()->cno;
    $car = Car::where('id', $id)->where('no_cif', $cnoShowroom)->firstOrFail();

    $request->validate([
        'foto_depan'    => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        'foto_belakang' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        'foto_samping'  => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        'foto_odometer' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
    ]);

    $fields = ['foto_depan', 'foto_belakang', 'foto_samping', 'foto_odometer'];
    $destinationPath = public_path('uploads/cars');

  foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                
                // 1. Buat nama file murni
                $filename = time() . '_' . $car->id . '_' . $field . '.' . $file->getClientOriginalExtension();

                // 2. Hapus file lama jika ada secara fisik
                if ($car->$field) {
                    // Bersihkan path lama untuk pengecekan file fisik
                    $oldFilename = str_replace('uploads/cars/', '', $car->$field);
                    if (File::exists($destinationPath . '/' . $oldFilename)) {
                        File::delete($destinationPath . '/' . $oldFilename);
                    }
                }

                // 3. Pindahkan file fisik ke folder public/uploads/cars
                $file->move($destinationPath, $filename);

                // 4. SIMPAN DENGAN PREFIX 'uploads/cars/' DI DEPANNYA (Menyamai format admin)
                $car->$field = 'uploads/cars/' . $filename;
            }
        }

    $car->save();

    return redirect()->route('showrooms.dashboard')->with('success', 'Semua foto unit berhasil diperbarui!');
}

public function edit_profile()
    {
        $user = auth()->user();
        return view('showrooms.settings', compact('user'));
    }
    
public function update_profile(Request $request)
    {
        $user = auth()->user();

        // Validasi input
        $request->validate([
            'nopic'    => 'nullable|string|max:20', // Validasi untuk nomor WhatsApp
            'password' => 'nullable|string|min:8|confirmed', // Password opsional, tapi jika diisi wajib konfirmasi
        ], [
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min'       => 'Password minimal harus 8 karakter.',
            'nopic.max'          => 'Nomor WhatsApp terlalu panjang.'
        ]);

        // Update Nomor WhatsApp (PIC)
        $user->nopic = $request->nopic;

        // Proses Ubah Password (hanya jika diisi)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Pengaturan akun showroom berhasil diperbarui.');
    }
}