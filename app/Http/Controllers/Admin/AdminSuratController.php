<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratAjuan;
use App\Models\LogAktivitas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

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
            'status' => 'required|in:selesai,ditolak',
            'pesan_admin' => 'nullable|string' // Alasan penolakan (opsional)
        ]);

        $surat = SuratAjuan::findOrFail($id);

        $surat->update([
            'status' => $request->status,
            // Jika disetujui, kita buatkan nomor surat otomatis
            // Format: SRT/NomorAcak/Tahun (Bisa disesuaikan nanti)
            'nomor_surat' => $request->status == 'selesai' ? 'SRT/'.rand(100,999).'/'.date('Y') : null
        ]);

        // REKAM AKTIVITAS
        LogAktivitas::create([
            'user_id' => Auth::id(), // ID Admin yang sedang login
            'aktivitas' => 'Memverifikasi surat milik ' . $surat->user->name . ' menjadi ' . $request->status,
        ]);

        return redirect()->route('admin.surat.index')->with('success', 'Status surat berhasil diperbarui!');
    }

    public function cetak($id)
    {
        $surat = SuratAjuan::with(['user', 'detailUsaha', 'detailNikah', 'detailTanah', 'detailKelahiran', 'detailKematian'])->findOrFail($id);

        // Cek apakah surat sudah disetujui (selesai)
        if ($surat->status != 'selesai') {
            return back()->with('error', 'Surat belum disetujui, tidak bisa dicetak!');
        }

        // Load View khusus PDF
        $pdf = Pdf::loadView('admin.surat.cetak', compact('surat'));

        // Atur ukuran kertas (F4/A4) dan orientasi
        $pdf->setPaper('A4', 'portrait');

        // Tampilkan PDF di browser (stream)
        return $pdf->stream('Surat-Keterangan-' . $surat->user->name . '.pdf');
    }
}