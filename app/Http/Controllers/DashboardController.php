<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SuratAjuan;
use App\Models\Pengaduan;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung-hitungan Statistik
        $totalWarga = User::where('role', 'warga')->count();
        $suratMenunggu = SuratAjuan::where('status', 'menunggu')->count();
        $pengaduanBaru = Pengaduan::where('status', 'masuk')->count();
        $suratSelesai = SuratAjuan::where('status', 'selesai')->count();

        // 2. Ambil 5 Surat Terbaru (Biar Admin langsung lihat)
        $suratTerbaru = SuratAjuan::with('user')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalWarga', 
            'suratMenunggu', 
            'pengaduanBaru', 
            'suratSelesai', 
            'suratTerbaru'
        ));
    }
}