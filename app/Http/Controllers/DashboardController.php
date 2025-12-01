<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratAjuan;
use App\Models\Pengaduan;
use App\Models\User;

class DashboardController extends Controller
{
   public function index()
    {
        // 1. Hitung-hitungan untuk Kartu Statistik
        $totalWarga   = User::where('role', 'warga')->count();
        
        // [PERBAIKAN] Hitung semua surat yang BUKAN selesai dan BUKAN ditolak
        // Ini akan menangkap 'menunggu', 'pending', 'proses', dll secara otomatis.
        $suratBaru    = SuratAjuan::whereNotIn('status', ['selesai', 'ditolak'])->count();
        
        $suratSelesai = SuratAjuan::where('status', 'selesai')->count();
        
        // [PERBAIKAN] Hitung pengaduan yang BUKAN selesai
        $aduanBaru    = Pengaduan::where('status', '!=', 'selesai')->count();

        // 2. Ambil 5 Surat Terakhir untuk Tabel Riwayat
        $suratTerbaru = SuratAjuan::with('user')->latest()->take(5)->get();

        // 3. Kirim semua data ke tampilan
        return view('dashboard', compact('totalWarga', 'suratBaru', 'suratSelesai', 'aduanBaru', 'suratTerbaru'));
    }
}