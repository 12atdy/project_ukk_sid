<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SuratAjuan;
use App\Models\Pengaduan;
use App\Models\User;
use App\Models\Biodata; 

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // LOGIKA UNTUK ADMIN
        if ($user->role == 'admin') {
            
            // 1. Data Statistik Kartu
            $totalSurat = SuratAjuan::count();
            $totalAduan = Pengaduan::count();
            
            // 2. Data Tabel Riwayat (5 Terakhir)
            $riwayatSurat = SuratAjuan::with('user')->latest()->take(5)->get();
            $riwayatAduan = Pengaduan::latest()->take(5)->get();

            // 3. DATA GRAFIK (INI FITUR BARUNYA)
            // Menghitung jumlah laki-laki & perempuan dari tabel biodata
            $laki = Biodata::where('jenis_kelamin', 'Laki-laki')->count();
            $perempuan = Biodata::where('jenis_kelamin', 'Perempuan')->count();

            return view('dashboard', compact(
                'totalSurat', 
                'totalAduan', 
                'riwayatSurat', 
                'riwayatAduan',
                'laki',       // <--- Kirim ke View
                'perempuan'   // <--- Kirim ke View
            ));
        } 
        
        // LOGIKA UNTUK WARGA (Dashboard Warga tidak berubah)
        else {
            return redirect()->route('warga.dashboard');
        }
    }
}