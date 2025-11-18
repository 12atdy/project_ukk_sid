<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Cek apakah user sudah login?
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Cek apakah role user SESUAI dengan yang diminta?
        if (Auth::user()->role == $role) {
            return $next($request); // Silakan masuk
        }

        // 3. Kalau role TIDAK sesuai, tendang balik
        // Misalnya, Warga coba masuk halaman Admin, kita lempar ke dashboard warga (atau home)
        return redirect('/'); 
    }
}