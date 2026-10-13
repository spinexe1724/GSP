<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // PENTING: Gunakan guard('web') secara spesifik untuk admin
        // Jangan gunakan Auth::check() polos agar tidak tertukar dengan guard showroom
        if (Auth::guard('web')->check() && Auth::guard('web')->user()->is_admin) {
            return $next($request);
        }

        // Jika bukan admin (misal sedang login sebagai showroom atau belum login), tolak atau redirect
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu sebagai Administrator.');
    }
}