<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuratAjuan;
use App\Models\LogAktivitas; // Pastikan import Log jika dipakai
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class AdminSuratController extends Controller
{
    // 1. DAFTAR SURAT MASUK (DENGAN SEARCH & PAGINATION)
    public function index(Request $request)
    {
        // Mulai query
        $query = SuratAjuan::with('user')->latest();

        // Logika Pencarian
        if ($request->has('search') && $request->search != null) {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                // Cari berdasarkan Jenis Surat
                $q->where('jenis_surat', 'like', "%$search%")
                  // Atau Cari berdasarkan Nomor Surat
                  ->orWhere('nomor_surat', 'like', "%$search%")
                  // Atau Cari berdasarkan Nama Pemohon (Relasi User)
                  ->orWhereHas('user', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%$search%");
                  });
            });
        }

        // Ambil data dengan Pagination (10 per halaman)
        // append(['search' => ...]) berguna supaya pas pindah halaman, kata kunci pencarian gak hilang
        $suratMasuk = $query->paginate(10)->appends(['search' => $request->search]);
        
        return view('admin.surat.index', compact('suratMasuk'));
    }

    // ... (Fungsi show, update, cetak biarkan tetap sama seperti sebelumnya) ...
    
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
            'pesan_admin' => 'nullable|string'
        ]);

        $surat = SuratAjuan::findOrFail($id);

        $surat->update([
            'status' => $request->status,
            'nomor_surat' => $request->status == 'selesai' ? 'SRT/'.rand(100,999).'/'.date('Y') : null
        ]);
        
        // Log Aktivitas (Jika kamu pakai fitur log kemarin)
        // LogAktivitas::create([...]); 

        return redirect()->route('admin.surat.index')->with('success', 'Status surat berhasil diperbarui!');
    }

    // 4. CETAK PDF
    public function cetak($id)
    {
        $surat = SuratAjuan::with(['user', 'detailUsaha', 'detailNikah', 'detailTanah', 'detailKelahiran', 'detailKematian'])->findOrFail($id);

        if ($surat->status != 'selesai') {
            return back()->with('error', 'Surat belum disetujui, tidak bisa dicetak!');
        }

        $pdf = Pdf::loadView('admin.surat.cetak', compact('surat'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Surat-Keterangan-' . $surat->user->name . '.pdf');
    }
}