<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Biodata;

class WargaController extends Controller
{
    // Dashboard Warga
    public function index()
    {
        return view('warga.dashboard');
    }

    // [BARU] Halaman Profil Saya
    public function profil()
    {
        $user = Auth::user();
        // Ambil biodata, kalau kosong bikin baru (biar gak error di view)
        $biodata = $user->biodata ?? new Biodata(); 
        
        return view('warga.profil', compact('user', 'biodata'));
    }

    // [BARU] Proses Simpan Biodata
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

        // Simpan atau Update data
        Biodata::updateOrCreate(
            ['user_id' => Auth::id()], // Kunci: cari berdasarkan ID user yg login
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