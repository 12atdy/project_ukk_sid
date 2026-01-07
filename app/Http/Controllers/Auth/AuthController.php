<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Biodata;
use Illuminate\Support\Facades\Hash;
use App\Models\LogAktivitas; // Jangan lupa ini untuk log logout

class AuthController extends Controller
{
    // Tampilkan Form Login
    public function showLoginForm()
    {
        // Cek jika sudah login, langsung lempar ke dashboard masing-masing
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('dashboard');
            } elseif (Auth::user()->role == 'warga') {
                return redirect()->route('warga.dashboard');
            }
        }
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // REKAM LOG LOGIN (Hanya jika belum terekam di middleware lain)
            // Cek dulu biar gak double kalau user refresh
            LogAktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Melakukan Login ke dalam sistem',
            ]);

            // Cek Role dan Redirect EKSPLISIT (Pasti)
            // Jangan pakai 'intended' dulu biar tidak bingung
            if (Auth::user()->role == 'admin') {
                return redirect()->route('dashboard');
            } elseif (Auth::user()->role == 'warga') {
                return redirect()->route('warga.dashboard');
            }
        }

        return back()->with('error', 'Email atau Password salah!');
    }

    // Tampilkan Form Register Warga
    public function showWargaRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('warga.dashboard');
        }
        return view('auth.register-warga');
    }

    // Proses Register Warga
    public function registerWarga(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:biodata,nik|digits:16',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // 1. Buat User Baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'warga',
        ]);

        // 2. Buat Biodata Awal
        Biodata::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'nama_lengkap' => $request->name, 
            // Kolom lain biarkan null/default
        ]);

        // 3. Login Otomatis
        Auth::login($user);
        $request->session()->regenerate(); // Penting untuk keamanan session baru

        // REKAM LOG REGISTER
        LogAktivitas::create([
            'user_id' => $user->id,
            'aktivitas' => 'Mendaftar akun warga baru',
        ]);

        // 4. Redirect Pasti ke Dashboard Warga
        return redirect()->route('warga.dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang.');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        // Rekam log sebelum session hancur
        if(Auth::check()){
            LogAktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Logout dari sistem',
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke Landing Page (Halaman Utama)
        return redirect('/'); 
    }
}