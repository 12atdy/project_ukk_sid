<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\TanggapanPengaduan;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    // 1. HALAMAN DAFTAR PENGADUAN
    public function index()
    {
        // Kalau ADMIN: Lihat SEMUA pengaduan
        if (Auth::user()->role == 'admin') {
            $pengaduan = Pengaduan::with('user')->latest()->get();
            return view('admin.pengaduan.index', compact('pengaduan'));
        } 
        // Kalau WARGA: Lihat pengaduan SAYA SAJA
        else {
            $pengaduan = Pengaduan::where('user_id', Auth::id())->latest()->get();
            return view('warga.pengaduan.index', compact('pengaduan'));
        }
    }

    // 2. FORM PENGADUAN BARU (Khusus Warga)
    public function create()
    {
        return view('warga.pengaduan.create');
    }   

    // 3. SIMPAN PENGADUAN KE DATABASE
    public function store(Request $request)
    {
        $request->validate([
            'judul_laporan' => 'required|string|max:255',
            'isi_laporan'   => 'required|string',
            'foto_bukti'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload Foto
        $pathFoto = null;
        if ($request->hasFile('foto_bukti')) {
            $pathFoto = $request->file('foto_bukti')->store('bukti-laporan', 'public');
        }

        // SIMPAN KE DATABASE (VERSI FIX 100%)
        Pengaduan::create([
            'user_id'       => Auth::id(),
            
            // Perbaiki nama kolom tanggal di bawah ini:
            'judul'         => $request->judul_laporan, 
            'isi_pengaduan' => $request->isi_laporan,
            'foto_bukti'    => $pathFoto,
            'status'        => 'masuk',
            'tanggal_lapor' => now(), 
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Laporan berhasil dikirim!');
    }

    // 4. LIHAT DETAIL & FORM BALAS (Untuk Admin & Warga)
    public function show($id)
    {
        $pengaduan = Pengaduan::with(['user', 'tanggapan.admin'])->findOrFail($id);
        
        // Security: Warga gak boleh intip laporan orang lain
        if (Auth::user()->role == 'warga' && $pengaduan->user_id != Auth::id()) {
            abort(403);
        }

        return view('pengaduan.show', compact('pengaduan'));
    }

    // 5. KIRIM TANGGAPAN (Khusus Admin)
    public function tanggapi(Request $request, $id)
    {
        $request->validate(['isi_tanggapan' => 'required']);

        $pengaduan = Pengaduan::findOrFail($id);

        // Simpan Tanggapan
        TanggapanPengaduan::create([
            'pengaduan_id'  => $pengaduan->id,
            'user_id'      => Auth::id(),
            'isi_tanggapan' => $request->isi_tanggapan,
            'tanggal_tanggapan' => now(),
        ]);

        // Update status pengaduan jadi 'selesai'
        $pengaduan->update(['status' => 'selesai']);

        return back()->with('success', 'Tanggapan berhasil dikirim!');
    }
}