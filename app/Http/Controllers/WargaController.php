<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratAjuan;
use App\Models\Pengaduan;
use App\Models\Biodata; 
use Illuminate\Support\Facades\Auth;
use App\Models\LogAktivitas;

class WargaController extends Controller
{
    public function index()
    {
        // 1. Ambil 5 Surat Terakhir (Bukan cuma 1)
        $riwayatSurat = SuratAjuan::where('user_id', Auth::id())
                            ->latest()
                            ->take(5)
                            ->get();

        // 2. Ambil 3 Pengaduan Terakhir
        $riwayatAduan = Pengaduan::where('user_id', Auth::id())
                            ->latest()
                            ->take(3)
                            ->get();

        // 3. Statistik Ringkas
        $totalSurat = SuratAjuan::where('user_id', Auth::id())->count();
        $totalAduan = Pengaduan::where('user_id', Auth::id())->count();

        return view('warga.dashboard', compact('riwayatSurat', 'riwayatAduan', 'totalSurat', 'totalAduan'));
    }

    // [BARU] Halaman Edit Profil
    public function profil()
    {
        // Ambil data biodata user yang sedang login
        // firstOrNew artinya: Kalau ada ambil, kalau belum ada buat kosongan (biar gak error null)
        $biodata = Biodata::firstOrNew(['user_id' => Auth::id()]);
        
        return view('warga.profil', compact('biodata'));
    }

    // [BARU] Proses Simpan Profil
    public function updateProfil(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric|digits:16',
            'no_kk' =>'required|numeric|digits:16',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'pekerjaan' => 'required',
        ]);

        // Update atau Buat Baru (updateOrCreate)
        Biodata::updateOrCreate(
            ['user_id' => Auth::id()], // Kunci pencarian (berdasarkan user yang login)
            [
                'nik' => $request->nik,
                'no_kk' => $request->no_kk,
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama' => $request->agama,
                'status_perkawinan' => $request->status_perkawinan,
                'pekerjaan' => $request->pekerjaan,
                'alamat' => $request->alamat,
            ]
        );

       \App\Helpers\LogHelper::catat('Warga memperbarui biodata profil diri');

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}