<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Biodata;

class BiodataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // app/Http/Controllers/BiodataController.php

    public function index()
    {
        $semuaBiodata = Biodata::all();
        // dd($semuaBiodata); // Hapus atau jadikan komentar
        return view('biodata.index', ['data_penduduk' => $semuaBiodata]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('biodata.create'); // Cuma nampilin form aja
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // 1. Validasi Input
    $this->validate($request, [
        'nik'           => 'required|digits:16|unique:biodata,nik',
        'nama_lengkap'  => 'required|string|min:3',
        'alamat'        => 'required|string|min:5'
    ]);

    // 2. Jika validasi berhasil, simpan data
    Biodata::create([
        'nik'           => $request->nik,
        'nama_lengkap'  => $request->nama_lengkap,
        'alamat'        => $request->alamat
    ]);

    // 3. Arahkan kembali ke halaman index dengan pesan sukses
    return redirect()->route('biodata.index')->with('success', 'Data penduduk berhasil ditambahkan!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    // 1. Cari data biodata berdasarkan ID. Jika tidak ketemu, akan error 404.
    $biodata = Biodata::findOrFail($id);

    // 2. Kirim data yang sudah ditemukan itu ke view 'biodata.edit'
    return view('biodata.edit', compact('biodata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi Input
    $this->validate($request, [
        'nik'           => 'required|digits:16|unique:biodata,nik,'.$id,
        'nama_lengkap'  => 'required|string|min:3',
        'alamat'        => 'required|string|min:5'
    ]);

    // Cari data berdasarkan ID
    $biodata = Biodata::findOrFail($id);

    // Update data
    $biodata->update([
        'nik'           => $request->nik,
        'nama_lengkap'  => $request->nama_lengkap,
        'alamat'        => $request->alamat
    ]);

    // Arahkan kembali ke halaman index dengan pesan sukses
    return redirect()->route('biodata.index')->with('success', 'Data penduduk berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         // Cari data berdasarkan ID
    $biodata = Biodata::findOrFail($id);

    // Hapus data
    $biodata->delete();

    // Arahkan kembali ke halaman index dengan pesan sukses
    return redirect()->route('biodata.index')->with('success', 'Data penduduk berhasil dihapus!');
    }
}
