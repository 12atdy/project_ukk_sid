<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\Admin\AdminSuratController; 
use App\Http\Controllers\PengaduanController; 

Route::get('/', function () {
    return view('home');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('register-warga', [AuthController::class, 'showWargaRegisterForm'])->name('warga.register');
Route::post('register-warga', [AuthController::class, 'registerWarga'])->name('warga.register.post');

// --- ADMIN ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('biodata', BiodataController::class);
    Route::resource('berita', BeritaController::class);

    Route::get('/admin/surat', [AdminSuratController::class, 'index'])->name('admin.surat.index');
    Route::get('/admin/surat/{id}', [AdminSuratController::class, 'show'])->name('admin.surat.show');
    Route::put('/admin/surat/{id}', [AdminSuratController::class, 'update'])->name('admin.surat.update');
    Route::get('/admin/surat/{id}/cetak', [AdminSuratController::class, 'cetak'])->name('admin.surat.cetak');

    Route::get('/admin/pengaduan', [PengaduanController::class, 'index'])->name('admin.pengaduan.index');
    Route::get('/admin/pengaduan/{id}', [PengaduanController::class, 'show'])->name('admin.pengaduan.show');
    Route::post('/admin/pengaduan/{id}/tanggapi', [PengaduanController::class, 'tanggapi'])->name('admin.pengaduan.tanggapi');
});

// --- WARGA ---
Route::middleware(['auth', 'role:warga'])->group(function () {
    Route::get('/portal-warga', [App\Http\Controllers\WargaController::class, 'index'])->name('warga.dashboard');
    
    // [BARU] Route Profil Warga
    Route::get('/portal-warga/profil', [App\Http\Controllers\WargaController::class, 'profil'])->name('warga.profil');
    Route::post('/portal-warga/profil', [App\Http\Controllers\WargaController::class, 'updateProfil'])->name('warga.profil.update');

    Route::resource('surat', App\Http\Controllers\SuratAjuanController::class);

    Route::get('/portal-warga/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/portal-warga/pengaduan/buat', [PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/portal-warga/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('/portal-warga/pengaduan/{id}', [PengaduanController::class, 'show'])->name('warga.pengaduan.show');
});