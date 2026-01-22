<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biodata;

class BiodataController extends Controller
{
    public function index()
    {
        $semuaBiodata = Biodata::all();
        return view('biodata.index', ['data_penduduk' => $semuaBiodata]);
    }

    public function create()
    {
        return view('biodata.create');
    }

   public function store(Request $request)
    {
        // 1. Validasi Lengkap
        $request->validate([
            'nik'               => 'required|digits:16|unique:biodata,nik',
            'nomor_kk'          => 'required|digits:16', // Tambahan
            'nama_lengkap'      => 'required|string|min:3',
            'tempat_lahir'      => 'required',           // Tambahan
            'tanggal_lahir'     => 'required|date',      // Tambahan
            'jenis_kelamin'     => 'required',           // Tambahan
            'agama'             => 'required',           // Tambahan
            'status_perkawinan' => 'required',           // Tambahan
            'pekerjaan'         => 'required',           // Tambahan
            'alamat'            => 'required|string|min:5'
        ]);

        // 2. Simpan Semua Data (Pakai $request->all() biar otomatis masuk semua)
        Biodata::create($request->all());

        return redirect()->route('admin.biodata.index')->with('success', 'Data penduduk berhasil ditambahkan!');
    }

    public function show(string $id)
    {
    // 1. Cari data berdasarkan ID
    $biodata = \App\Models\Biodata::findOrFail($id);

    // 2. Tampilkan View (Perhatikan nama 'admin.' di depannya)
    return view('admin.biodata.show', compact('biodata'));
    }

    public function edit(string $id)
    {
        $biodata = Biodata::findOrFail($id);
        return view('biodata.edit', compact('biodata'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nik'               => 'required|digits:16|unique:biodata,nik,'.$id,
            'nomor_kk'          => 'required|digits:16',
            'nama_lengkap'      => 'required|string|min:3',
            'tempat_lahir'      => 'required',
            'tanggal_lahir'     => 'required|date',
            'jenis_kelamin'     => 'required',
            'agama'             => 'required',
            'status_perkawinan' => 'required',
            'pekerjaan'         => 'required',
            'alamat'            => 'required|string|min:5'
        ]);

        $biodata = Biodata::findOrFail($id);

        // Update Semua Data
        $biodata->update($request->all());

        return redirect()->route('admin.biodata.index')->with('success', 'Data penduduk berhasil diubah!');
    }

    public function destroy(string $id)
    {
        $biodata = Biodata::findOrFail($id);
        $biodata->delete();

        // [PERBAIKAN] Tambahkan 'admin.' di sini
        return redirect()->route('admin.biodata.index')->with('success', 'Data penduduk berhasil dihapus!');
    }
}
