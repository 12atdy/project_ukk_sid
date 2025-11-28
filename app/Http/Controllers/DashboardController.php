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
        // 1. Hitung Statistik untuk Kartu Atas
        $totalWarga     = User::where('role', 'warga')->count();
        $suratMenunggu  = SuratAjuan::where('status', 'menunggu')->count();
        $pengaduanBaru  = Pengaduan::where('status', 'masuk')->count(); // 'masuk' sesuai enum di database
        $suratSelesai   = SuratAjuan::where('status', 'selesai')->count();

        // 2. Ambil 5 Surat Terbaru (Biar Admin langsung lihat siapa yang baru request)
        $suratTerbaru = SuratAjuan::with('user')->latest()->take(5)->get();

        // Kirim semua data ke View
        return view('dashboard', compact(
            'totalWarga', 
            'suratMenunggu', 
            'pengaduanBaru', 
            'suratSelesai', 
            'suratTerbaru'
        ));
    }
}