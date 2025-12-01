<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratAjuan;
use App\Models\Pengaduan;
use App\Models\Biodata; // Jangan lupa import ini
use Illuminate\Support\Facades\Auth;

class WargaController extends Controller
{
    public function index()
    {
        // 1. Ambil Surat Terakhir
        $suratTerakhir = SuratAjuan::where('user_id', Auth::id())->latest()->first();

        // 2. Ambil Pengaduan Terakhir
        $aduanTerakhir = Pengaduan::where('user_id', Auth::id())->latest()->first();

        // 3. Hitung total surat
        $totalSurat = SuratAjuan::where('user_id', Auth::id())->count();

        return view('warga.dashboard', compact('suratTerakhir', 'aduanTerakhir', 'totalSurat'));
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

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}