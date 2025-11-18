<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratAjuan;
use Illuminate\Support\Facades\Auth;

class SuratAjuanController extends Controller
{
    // 1. Tampilkan halaman daftar surat saya (History)
    public function index()
    {
        // Ambil surat hanya punya user yang sedang login
        $suratSaya = SuratAjuan::where('user_id', Auth::id())->latest()->get();
        return view('warga.surat.index', compact('suratSaya'));
    }

    // 2. Tampilkan form pengajuan baru
    public function create()
    {
        return view('warga.surat.create');
    }

    // 3. Simpan pengajuan ke database
    public function store(Request $request)
    {
        $request->validate([
            'jenis_surat' => 'required|string',
            'keterangan'  => 'nullable|string' // Opsional, buat catatan tambahan warga
        ]);

        SuratAjuan::create([
            'user_id'       => Auth::id(),
            'jenis_surat'   => $request->jenis_surat,
            'tanggal_ajuan' => now(), // Tanggal hari ini
            'status'        => 'menunggu', // Default status
            // 'nomor_surat' dikosongkan dulu, nanti diisi Admin
        ]);

        return redirect()->route('surat.index')->with('success', 'Surat berhasil diajukan! Mohon tunggu verifikasi admin.');
    }
}  