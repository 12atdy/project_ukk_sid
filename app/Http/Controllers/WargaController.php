<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratAjuan;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Auth;

class WargaController extends Controller
{
    public function index()
    {
        // 1. Ambil Surat Terakhir milik user ini
        $suratTerakhir = SuratAjuan::where('user_id', Auth::id())
                            ->latest()
                            ->first();

        // 2. Ambil Pengaduan Terakhir milik user ini
        $aduanTerakhir = Pengaduan::where('user_id', Auth::id())
                            ->latest()
                            ->first();

        // 3. Hitung total surat yang pernah diajukan (Opsional, buat statistik kecil)
        $totalSurat = SuratAjuan::where('user_id', Auth::id())->count();

        return view('warga.dashboard', compact('suratTerakhir', 'aduanTerakhir', 'totalSurat'));
    }
}