<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\Admin\AdminSuratController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\SuratAjuanController;
use App\Http\Controllers\Admin\KeuanganController; 
use App\Models\Berita;
use App\Models\LogAktivitas;
use Kreait\Firebase\Factory;


// --- HALAMAN DEPAN (LANDING PAGE) ---
Route::get('/', function () {
    // Cek jika user sudah login, langsung lempar ke dashboard
    if (Auth::check()) {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role == 'warga') {
            return redirect()->route('warga.dashboard');
        }
    }

    // Ambil berita untuk landing page
    $beritaTerbaru = Berita::latest()->take(3)->get();
    return view('welcome', compact('beritaTerbaru'));
});

// --- ROUTE PUBLIK ---
Route::get('/berita/baca/{id}', [BeritaController::class, 'baca'])->name('berita.baca');
Route::get('/transparansi-anggaran', [KeuanganController::class, 'transparansi'])->name('warga.transparansi');

// --- AUTH (LOGIN & REGISTER) ---
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('register-warga', [AuthController::class, 'showWargaRegisterForm'])->name('warga.register');
Route::post('register-warga', [AuthController::class, 'registerWarga'])->name('warga.register.post');

Route::get('/verifikasi-akun', [AuthController::class, 'showVerificationForm'])->name('verification.notice');
Route::post('/verifikasi-akun', [AuthController::class, 'verifyOtp'])->name('verification.verify');

// --- LUPA PASSWORD ---
Route::get('lupa-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('lupa-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');


// ====================================================
// ROLE: ADMIN
// ====================================================
// Semua route di sini otomatis punya awalan 'admin.' pada namanya
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    
    // Dashboard (Jadinya: admin.dashboard)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data
    Route::resource('biodata', BiodataController::class);
    Route::resource('berita', BeritaController::class);
    Route::resource('keuangan', KeuanganController::class); 

    // Kelola Surat
    Route::get('/surat', [AdminSuratController::class, 'index'])->name('surat.index');
    Route::get('/surat/{id}', [AdminSuratController::class, 'show'])->name('surat.show');
    Route::put('/surat/{id}', [AdminSuratController::class, 'update'])->name('surat.update');
    Route::get('/surat/{id}/cetak', [AdminSuratController::class, 'cetak'])->name('surat.cetak');

    // Kelola Pengaduan
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::post('/pengaduan/{id}/tanggapi', [PengaduanController::class, 'tanggapi'])->name('pengaduan.tanggapi');

   // Log Aktivitas (VERSI FIREBASE)
    Route::get('/log', function() {
        try {
            // 1. Konek ke Firebase
            $factory = (new Factory)
                ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
                ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));
            
            $database = $factory->createDatabase();

            // 2. Ambil 50 data terakhir & Urutkan
            $reference = $database->getReference('logs')
                                  ->orderByChild('timestamp')
                                  ->limitToLast(50);
            
            $snapshot = $reference->getSnapshot();
            $logs = $snapshot->getValue(); // Hasilnya berupa Array

            // 3. Balik urutan biar yang terbaru di atas
            // Kalau null (kosong), set jadi array kosong []
            $logs = $logs ? array_reverse($logs) : [];

        } catch (\Exception $e) {
            // Kalau error, kasih array kosong biar gak crash
            $logs = []; 
        }

        return view('admin.log.index', compact('logs'));
    })->name('log.index');
});


// ====================================================
// ROLE: WARGA
// ====================================================
Route::middleware(['auth', 'role:warga'])->group(function () {
    // Dashboard (Jadinya: warga.dashboard)
    Route::get('/portal-warga', [WargaController::class, 'index'])->name('warga.dashboard');
    
    // Profil
    Route::get('/portal-warga/profil', [WargaController::class, 'profil'])->name('warga.profil');
    Route::post('/portal-warga/profil', [WargaController::class, 'updateProfil'])->name('warga.profil.update');

    // Layanan Surat
    Route::resource('surat', SuratAjuanController::class);

    // Pengaduan Warga
    Route::get('/portal-warga/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/portal-warga/pengaduan/buat', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/portal-warga/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('/portal-warga/pengaduan/{id}', [PengaduanController::class, 'show'])->name('warga.pengaduan.show');

    // RUTE KHUSUS CETAK MANDIRI
    Route::get('/surat/{id}/cetak-mandiri', [SuratAjuanController::class, 'cetakMandiri'])->name('surat.cetak_mandiri');
});

// Route untuk Verifikasi QR Code
Route::get('/cek-surat/{id}', function($id) {
    // Cari surat berdasarkan ID
    $surat = \App\Models\SuratAjuan::find($id);
    
    // Tampilan sederhana untuk verifikasi
    if(!$surat) {
        return "<h1 style='color:red; text-align:center;'>SURAT TIDAK DITEMUKAN / PALSU!</h1>";
    }

    return "<div style='text-align:center; padding:50px; font-family:sans-serif;'>
                <h1 style='color:green;'>VERIFIED / ASLI &#10004;</h1>
                <p>Surat ini benar dikeluarkan oleh Desa Sidokerto.</p>
                <p><strong>Nomor Surat:</strong> {$surat->nomor_surat}</p>
                <p><strong>Pemilik:</strong> {$surat->user->name}</p>
                <p><strong>Tanggal:</strong> {$surat->created_at->format('d M Y')}</p>
            </div>";
    })->name('cek.surat');
    