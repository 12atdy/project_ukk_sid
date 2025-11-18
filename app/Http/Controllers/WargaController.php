<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WargaController extends Controller
{
    public function index()
    {
        // Menampilkan halaman dashboard khusus warga
        return view('warga.dashboard');
    }
}