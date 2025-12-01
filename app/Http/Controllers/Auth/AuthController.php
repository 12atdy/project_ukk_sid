<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\lOGAktivitas;

class AuthController extends Controller
{
    // ==========================================================
    // BAGIAN FORM & LOGIN
    // ==========================================================

    // Menampilkan form registrasi KHUSUS WARGA
    public function showWargaRegisterForm()
    {
        return view('auth.register-warga');
    }

    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses Login
   public function login(Request $request)
    {
        // 1. Validasi
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Coba autentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // REKAM AKTIVITAS
            LogAktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Melakukan Login ke dalam sistem',
            ]);

            // Cek Role untuk Redirect
            if (Auth::user()->role == 'admin') {
                return redirect()->intended(route('dashboard'));
            } else {
                // 👇 PERBAIKAN DI SINI: Arahkan ke route 'warga.dashboard'
                return redirect()->route('warga.dashboard'); 
            }
        }

        // 3. Jika gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/'); // Arahkan ke halaman depan
    }

    // ==========================================================
    // BAGIAN PROSES REGISTRASI
    // ==========================================================
    
    // Memproses data registrasi KHUSUS WARGA
    public function registerWarga(Request $request)
    {
        // 1. Validasi 
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Buat user baru dengan ROLE 'warga'
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'warga' 
        ]);


        // 4. Redirect
        // 👇 PERUBAHAN 2: Setelah daftar, langsung masuk ke Portal Warga
        return redirect()->route('warga.dashboard'); 
    }
}