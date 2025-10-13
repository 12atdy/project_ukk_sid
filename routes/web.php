<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('home');
});

// Route untuk menampilkan form
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');

// Route untuk memproses data dari form
Route::post('register', [AuthController::class, 'register'])->name('register.post');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('biodata', BiodataController::class)->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')->name('dashboard');

