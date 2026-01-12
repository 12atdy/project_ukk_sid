<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Biodata;
use Illuminate\Support\Facades\Hash;
use App\Models\LogAktivitas;

class AuthController extends Controller
{
    // Tampilkan Form Login
    public function showLoginForm()
    {
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

            // [PERBAIKAN LOGIKA]
            // Cek dulu apakah user punya role
            $role = Auth::user()->role;

            if ($role == 'admin') {
                // Rekam Log
                LogAktivitas::create([
                    'user_id' => Auth::id(),
                    'aktivitas' => 'Melakukan Login sebagai Admin',
                ]);
                return redirect()->intended('dashboard');

            } elseif ($role == 'warga') {
                // Rekam Log
                LogAktivitas::create([
                    'user_id' => Auth::id(),
                    'aktivitas' => 'Melakukan Login sebagai Warga',
                ]);
                return redirect()->intended('portal-warga');

            } else {
                // [PENTING] Jika Role Kosong/Salah, Tendang Keluar!
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return back()->with('error', 'Akun bermasalah (Role tidak ditemukan). Silakan daftar ulang atau hubungi Admin.');
            }
        }

        return back()->with('error', 'Email atau Password salah!');
    }

    // Tampilkan Form Register Warga
    public function showWargaRegisterForm()
    {
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
        // Pastikan file app/Models/User.php sudah ada 'role' di $fillable
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
        ]);

        // 3. Rekam Log (Manual ID karena belum login)
        LogAktivitas::create([
            'user_id' => $user->id,
            'aktivitas' => 'Mendaftar akun warga baru',
        ]);

        // 4. Arahkan ke Halaman Login dengan Pesan Sukses
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login dengan akun baru anda.');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        if(Auth::check()){
            LogAktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Logout dari sistem',
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}