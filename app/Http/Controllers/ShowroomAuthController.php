<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Showroom;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ShowroomAuthController extends Controller
{
    // ==========================================
    // BAGIAN REGISTRASI
    // ==========================================
    public function showRegisterForm()
    {
        return view('showrooms.auth.register'); 
    }

    public function register(Request $request)
    {
      $request->validate([
        'email'     => 'required|email|unique:users,email',
        'password'  => 'required|min:6',
        'clprnoktp' => 'required|numeric|digits:16|exists:showrooms,clprnoktp', // <-- Ubah di sini
    ], [
        'clprnoktp.exists' => 'Nomor KTP tidak terdaftar sebagai Partner Showroom Gratama.',
        'clprnoktp.digits' => 'Nomor KTP harus tepat 16 digit angka.',
        'email.unique'     => 'Email ini sudah dipakai oleh showroom lain.'
    ]);

    // Pastikan pencarian juga diubah
    $showroom = Showroom::where('clprnoktp', $request->clprnoktp)->first(); // <-- Ubah di sini

        if (User::where('showroom_id', $showroom->id)->exists()) {
            return back()->withErrors(['no_ktp' => 'Akun untuk KTP ini sudah pernah dibuat. Silakan Login.'])->withInput();
        }

  $user = User::create([
            'name'        => $showroom->nmdealer,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'showroom_id' => $showroom->id,
            'role'        => 'showroom',
            
            // JALAN KELUAR: Tangkap 'clprnoktp' atau 'no_ktp' (mana saja yang dikirim oleh form)
            'clprnoktp'   => $request->clprnoktp ?? $request->no_ktp, 
        ]);

      return redirect()->route('showrooms.login')
                         ->with('success', 'Registrasi akun ' . $showroom->nmdealer . ' berhasil! Silakan login untuk melanjutkan.');
    }

    // ==========================================
    // BAGIAN LOGIN & LOGOUT (BARU)
    // ==========================================
    
    // Menampilkan halaman form login
    public function showLoginForm()
    {
        // Sesuaikan nama view ini jika lokasi file login.blade.php Anda berbeda
        return view('showrooms.auth.login'); 
    }

    // Memproses data login
   public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect ke halaman dashboard setelah sukses login
return redirect()->route('showrooms.dashboard');        }

        return back()->with('error', 'Email atau password yang Anda masukkan tidak sesuai.')->onlyInput('email');
    }
    // Memproses logout
    public function logout(Request $request)
    {
     Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Arahkan kembali ke /showrooms/login
        return redirect()->route('showrooms.login')->with('success', 'Anda telah berhasil keluar.');
    }
}