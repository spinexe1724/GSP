<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

if (Auth::user()->is_admin) {
        return redirect()->intended(route('admin.dashboard'));
    }

    // Jika user biasa / showroom
    return redirect()->intended(route('cars.index'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
   // Hanya logout dari guard web (admin)
   Auth::guard('web')->logout();

    // 2. Hanya hapus kunci session login web, jangan hancurkan session lain
    $request->session()->forget('login_web_' . sha1(get_class(Auth::guard('web')->getProvider())));
    $request->session()->regenerateToken();

    return redirect('/login'); // atau halaman login admin Anda
    }
}
