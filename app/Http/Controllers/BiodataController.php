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
        // 1. Validasi Input
        $this->validate($request, [
            'nik'           => 'required|digits:16|unique:biodata,nik',
            'nama_lengkap'  => 'required|string|min:3',
            'alamat'        => 'required|string|min:5'
        ]);

        // 2. Simpan data
        Biodata::create([
            'nik'           => $request->nik,
            'nama_lengkap'  => $request->nama_lengkap,
            'alamat'        => $request->alamat
        ]);

        // [PERBAIKAN] Tambahkan 'admin.' di sini
        return redirect()->route('admin.biodata.index')->with('success', 'Data penduduk berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $biodata = Biodata::findOrFail($id);
        return view('biodata.edit', compact('biodata'));
    }

    public function update(Request $request, string $id)
    {
        // Validasi Input
        $this->validate($request, [
            'nik'           => 'required|digits:16|unique:biodata,nik,'.$id,
            'nama_lengkap'  => 'required|string|min:3',
            'alamat'        => 'required|string|min:5'
        ]);

        $biodata = Biodata::findOrFail($id);

        $biodata->update([
            'nik'           => $request->nik,
            'nama_lengkap'  => $request->nama_lengkap,
            'alamat'        => $request->alamat
        ]);

        // [PERBAIKAN] Tambahkan 'admin.' di sini
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