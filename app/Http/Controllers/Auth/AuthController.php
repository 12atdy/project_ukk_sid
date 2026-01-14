<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Biodata;
use Illuminate\Support\Facades\Hash;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail; 
use Carbon\Carbon;



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

            // [PERBAIKAN UTAMA ADA DISINI]
            $role = Auth::user()->role;

            if ($role == 'admin') {
                // Rekam Log
                LogAktivitas::create([
                    'user_id' => Auth::id(),
                    'aktivitas' => 'Melakukan Login sebagai Admin',
                ]);
                
                // GUNAKAN ->route() BUKAN ->intended('string')
                return redirect()->route('admin.dashboard');

            } elseif ($role == 'warga') {
                // Rekam Log
                LogAktivitas::create([
                    'user_id' => Auth::id(),
                    'aktivitas' => 'Melakukan Login sebagai Warga',
                ]);

                // GUNAKAN ->route()
                return redirect()->route('warga.dashboard');

            } else {
                // Jika Role tidak jelas, logout paksa
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return back()->with('error', 'Akun bermasalah (Role tidak ditemukan).');
            }
        }

        return back()->with('error', 'Email atau Password salah!');
    }

    // --- LOGIKA LUPA PASSWORD ---

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
            $user->save();
            event(new PasswordReset($user));
        });

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    // --- REGISTRASI WARGA ---

    public function showWargaRegisterForm()
    {
        return view('auth.register-warga');
    }

    public function registerWarga(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:biodata,nik|digits:16',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $otpCode = rand(100000, 999999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'warga', 
            'otp_code' => $otpCode,
            'otp_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        Biodata::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'nama_lengkap' => $request->name,
        ]);

        // 4. Kirim Email OTP (Kita buat mailer-nya habis ini)
        try {
        // Pastikan sudah menambahkan: use App\Mail\SendOtpMail; di paling atas file
            Mail::to($user->email)->send(new SendOtpMail($user, $otpCode));
        } catch (\Exception $e) {
        // Jika gagal kirim email, biarkan saja dulu (untuk dev)
        }

        // 5. Arahkan ke Halaman Verifikasi (Bawa Emailnya)
        return redirect()->route('verification.notice', ['email' => $user->email]);

        LogAktivitas::create([
            'user_id' => $user->id,
            'aktivitas' => 'Mendaftar akun warga baru',
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

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

    public function showVerificationForm(Request $request)
    {
        $email = $request->query('email');
        return view('auth.verify-otp', compact('email'));
    }

    // Proses Cek OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek apakah User ada & OTP cocok & Belum expired
        if ($user && $user->otp_code == $request->otp) {
            if (Carbon::now()->gt($user->otp_expires_at)) {
                return back()->with('error', 'Kode OTP sudah kadaluarsa. Silakan daftar ulang/minta kode baru.');
            }

            // Hapus OTP (biar gak bisa dipake lagi) dan Verifikasi Email
            $user->update([
                'otp_code' => null,
                'otp_expires_at' => null,
                'email_verified_at' => Carbon::now(),
            ]);

            // Login Otomatis
            Auth::login($user);

            // Rekam Log
            LogAktivitas::create([
                'user_id' => $user->id,
                'aktivitas' => 'Berhasil verifikasi akun baru',
            ]);

            return redirect()->route('warga.dashboard')->with('success', 'Akun berhasil diverifikasi!');
        }

        return back()->with('error', 'Kode OTP salah!');
    }
}