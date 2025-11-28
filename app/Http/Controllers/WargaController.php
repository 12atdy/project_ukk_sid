<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Biodata;
use App\Models\SuratAjuan; 
use App\Models\Pengaduan;

class WargaController extends Controller
{
    // 1. Dashboard Warga (Tampilkan Statistik & Pintasan)
    public function index()
    {
        $user = Auth::user();
        
        // Hitung statistik PRIBADI (Bukan semua warga)
        $totalSurat = SuratAjuan::where('user_id', $user->id)->count();
        $suratSelesai = SuratAjuan::where('user_id', $user->id)->where('status', 'selesai')->count();
        $pengaduanSaya = Pengaduan::where('user_id', $user->id)->count();

        // Ambil 3 Riwayat Terakhir
        $riwayatTerakhir = SuratAjuan::where('user_id', $user->id)->latest()->take(3)->get();

        return view('warga.dashboard', compact('user', 'totalSurat', 'suratSelesai', 'pengaduanSaya', 'riwayatTerakhir'));
    }

    // 2. Halaman Profil
    public function profil()
    {
        $user = Auth::user();
        $biodata = $user->biodata ?? new Biodata(); 
        
        return view('warga.profil', compact('user', 'biodata'));
    }

    // 3. Proses Simpan Profil
    public function updateProfil(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'pekerjaan' => 'required',
        ]);

        Biodata::updateOrCreate(
            ['user_id' => Auth::id()], 
            [
                'nik' => $request->nik,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'pekerjaan' => $request->pekerjaan,
            ]
        );

        return redirect()->back()->with('success', 'Biodata berhasil diperbarui!');
    }
}