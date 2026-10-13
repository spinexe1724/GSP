<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Showroom;

class ShowroomAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('showrooms.auth.login'); // Buat view login Anda di sini
    }

    public function login(Request $request)
    {
        $request->validate([
            'clprnoktp' => 'required',
            'password' => 'required'
        ]);

        $ktp = trim($request->clprnoktp);
        $password = $request->password;

        // 1. Cari showroom berdasarkan no KTP
        $showroom = Showroom::where('clprnoktp', $ktp)->first();

        // 2. Jika tidak ketemu, KTP kosong, atau format salah (misal panjang KTP < 16 digit)
        if (!$showroom || empty($showroom->clprnoktp) || strlen($showroom->clprnoktp) < 10) {
            return back()->with('error', 'Showroom belum terdaftar atau format clprnoktp salah.');
        }

        // 3. Lazy Password Hashing (Untuk login pertama kali)
        // Jika kolom password di DB masih kosong, dan input password sama dengan clprnoktp
        if (empty($showroom->password) && $password === $showroom->clprnoktp) {
            $showroom->password = Hash::make($password);
            $showroom->save();
        }

        // 4. Lakukan pengecekan otentikasi
       if (Auth::guard('showroom')->attempt(['clprnoktp' => $ktp, 'password' => $password])) {
        $request->session()->regenerate();
            
            // Arahkan ke dashboard showroom
return redirect()->route('showrooms.dashboard');
        }

        return back()->with('error', 'Password yang Anda masukkan salah.');
    }

    public function logout(Request $request)
    {
     Auth::guard('showroom')->logout();

    // 2. Hanya hapus kunci session login showroom
    $request->session()->forget('login_showroom_' . sha1(get_class(Auth::guard('showroom')->getProvider())));
    $request->session()->regenerateToken();

   return redirect()->route('showrooms.login'); // BENAR
    }
}