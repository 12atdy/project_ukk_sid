<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratAjuan;

class AdminSuratController extends Controller
{
    // 1. DAFTAR SURAT MASUK
    public function index()
    {
        // Ambil semua surat, urutkan dari yang terbaru
        // 'user' kita ambil biar nama pemohon muncul
        $suratMasuk = SuratAjuan::with('user')->latest()->get();
        return view('admin.surat.index', compact('suratMasuk'));
    }

    // 2. LIHAT DETAIL & VERIFIKASI
    public function show($id)
    {
        $surat = SuratAjuan::with(['user', 'detailUsaha', 'detailNikah', 'detailTanah', 'detailKelahiran', 'detailKematian'])->findOrFail($id);
        
        return view('admin.surat.show', compact('surat'));
    }

    // 3. PROSES ACC / TOLAK
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'pesan_admin' => 'nullable|string' // Alasan penolakan (opsional)
        ]);

        $surat = SuratAjuan::findOrFail($id);

        $surat->update([
            'status' => $request->status,
            // Jika disetujui, kita buatkan nomor surat otomatis
            // Format: SRT/NomorAcak/Tahun (Bisa disesuaikan nanti)
            'nomor_surat' => $request->status == 'disetujui' ? 'SRT/'.rand(100,999).'/'.date('Y') : null
        ]);

        return redirect()->route('admin.surat.index')->with('success', 'Status surat berhasil diperbarui!');
    }
}