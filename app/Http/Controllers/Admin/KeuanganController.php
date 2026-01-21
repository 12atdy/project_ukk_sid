<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    // --- HALAMAN ADMIN (CRUD) ---
    public function index()
    {
        $data = Keuangan::latest()->paginate(10);
        
        // Hitung Rekapitulasi untuk Widget Atas
        $pemasukan = Keuangan::where('jenis_transaksi', 'Pemasukan')->sum('jumlah');
        $pengeluaran = Keuangan::where('jenis_transaksi', 'Pengeluaran')->sum('jumlah');
        $saldo = $pemasukan - $pengeluaran;

        return view('admin.keuangan.index', compact('data', 'pemasukan', 'pengeluaran', 'saldo'));
    }

    public function create()
    {
        return view('admin.keuangan.create');
    }

    public function store(Request $request)
    {
    // 1. Validasi diperbaiki & dilengkapi
    $request->validate([
        'kode_transaksi'    => 'required|unique:keuangan,kode_transaksi',
        'jenis_transaksi'   => 'required',
        'jumlah'            => 'required|numeric',
        'tanggal_transaksi' => 'required|date', // <--- Pastikan nama di View sama dengan ini
        'sumber_penerima'   => 'required|string', // <--- Tadi ini belum ada
        'penanggung_jawab'  => 'required|string', // <--- Tadi ini belum ada
        'keterangan'        => 'required',
        'bukti'             => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $input = $request->all();
    $input['user_id'] = Auth::id();

    if ($request->hasFile('bukti')) {
        $file = $request->file('bukti');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('bukti_keuangan', $filename, 'public');
        $input['bukti'] = $path;
    }

    Keuangan::create($input);

    return redirect()->route('admin.keuangan.index')->with('success', 'Data keuangan berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $item = Keuangan::findOrFail($id);
        
        // Hapus file bukti jika ada
        if ($item->bukti) {
            Storage::disk('public')->delete($item->bukti);
        }
        
        $item->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }

    // --- HALAMAN TRANSPARANSI (UNTUK WARGA) ---
    public function transparansi()
    {
        // Ambil data tahun ini saja biar relevan
        $tahun = date('Y');
        
        $pemasukan = Keuangan::where('jenis_transaksi', 'Pemasukan')->whereYear('tanggal_transaksi', $tahun)->sum('jumlah');
        $pengeluaran = Keuangan::where('jenis_transaksi', 'Pengeluaran')->whereYear('tanggal_transaksi', $tahun)->sum('jumlah');
        $saldo = $pemasukan - $pengeluaran;
        
        // Data tabel untuk warga (tampilkan yang terbaru)
        $riwayat = Keuangan::latest()->take(20)->get();

        return view('warga.keuangan.transparansi', compact('pemasukan', 'pengeluaran', 'saldo', 'riwayat', 'tahun'));
    }
}