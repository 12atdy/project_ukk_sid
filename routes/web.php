<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BeritaController;

/*
|--------------------------------------------------------------------------
| 1. ROUTE PUBLIK (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('home');
});

/*
|--------------------------------------------------------------------------
| 2. ROUTE AUTENTIKASI (Login, Register, Logout)
|--------------------------------------------------------------------------
*/
// -- Jalur Admin/Umum --
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');

// -- Jalur Login --
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// -- Jalur Khusus Warga --
Route::get('register-warga', [AuthController::class, 'showWargaRegisterForm'])->name('warga.register');
Route::post('register-warga', [AuthController::class, 'registerWarga'])->name('warga.register.post');

/*
|--------------------------------------------------------------------------
| 3. ROUTE KHUSUS ADMIN (Dijaga Satpam)
|--------------------------------------------------------------------------
| Hanya user yang sudah LOGIN ('auth') DAN punya role ADMIN ('role:admin')
| yang boleh masuk ke sini.
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Biodata
    Route::resource('biodata', BiodataController::class);

    // CRUD Berita
    Route::resource('berita', BeritaController::class);
    
});

/*
|--------------------------------------------------------------------------
| 4. ROUTE KHUSUS WARGA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:warga'])->group(function () {
    
    Route::get('/portal-warga', [App\Http\Controllers\WargaController::class, 'index'])->name('warga.dashboard');

    Route::resource('surat', App\Http\Controllers\SuratAjuanController::class);

});