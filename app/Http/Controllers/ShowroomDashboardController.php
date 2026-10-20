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
        $cnoShowroom = Auth::guard('showroom')->user()->cno; 

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
        $car = Car::where('id', $id)->where('no_cif', $cnoShowroom)->firstOrFail();

        return view('showrooms.cars.edit-foto', compact('car'));
    }

    public function updateFoto(Request $request, $id)
    {
        $cnoShowroom = Auth::guard('showroom')->user()->cno;
        $car = Car::where('id', $id)->where('no_cif', $cnoShowroom)->firstOrFail();

        $request->validate([
            'harga'         => 'nullable|numeric|min:0', // Validasi input harga (opsional)
            'foto_depan'    => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'foto_belakang' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'foto_samping'  => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'foto_odometer' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // Simpan harga baru (jika diisi akan tersimpan angka, jika kosong bernilai null)
        $car->harga = $request->harga;

        $fields = ['foto_depan', 'foto_belakang', 'foto_samping', 'foto_odometer'];
        $destinationPath = public_path('uploads/cars');

        foreach ($fields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                
                $filename = time() . '_' . $car->id . '_' . $field . '.' . $file->getClientOriginalExtension();

                if ($car->$field) {
                    $oldFilename = str_replace('uploads/cars/', '', $car->$field);
                    if (File::exists($destinationPath . '/' . $oldFilename)) {
                        File::delete($destinationPath . '/' . $oldFilename);
                    }
                }

                $file->move($destinationPath, $filename);
                $car->$field = 'uploads/cars/' . $filename;
            }
        }

        $car->save();

        return redirect()->route('showrooms.dashboard')->with('success', 'Detail unit dan foto berhasil diperbarui!');
    }

    public function edit_profile()
    {
        $user = auth()->user();
        return view('showrooms.settings', compact('user'));
    }
    
    public function update_profile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nopic'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min'       => 'Password minimal harus 8 karakter.',
            'nopic.max'          => 'Nomor WhatsApp terlalu panjang.'
        ]);

        $user->nopic = $request->nopic;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Pengaturan akun showroom berhasil diperbarui.');
    }
}