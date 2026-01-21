<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua berita, urutkan dari yang terbaru
        $semuaBerita = Berita::latest()->with('user')->paginate(10);
        return view('berita.index', compact('semuaBerita'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $this->validate($request, [
            'gambar' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'judul'  => 'required|min:5',
            'isi'    => 'required|min:10'
        ]);

        // 2. Simpan gambar
        $path = $request->file('gambar')->store('berita', 'public');

        // 3. Buat berita baru
        Berita::create([
            'gambar'  => basename($path), 
            'judul'   => $request->judul,
            'isi'     => $request->isi,
            'user_id' => Auth::id()
        ]);

        // [UPDATE] Pakai Log Helper Firebase (Biar masuk ke Admin Log)
        \App\Helpers\LogHelper::catat('Memposting berita baru: ' . $request->judul);

        // 4. Redirect ke 'admin.berita.index' (BUKAN 'berita.index')
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dipublikasikan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $berita = Berita::findOrFail($id);
        return view('berita.edit', compact('berita'));
    }

    /**
     * Menyimpan perubahan dari form edit.
     */
    public function update(Request $request, string $id)
    {
        // 1. Validasi
        $this->validate($request, [
            'gambar' => 'image|mimes:jpeg,jpg,png|max:2048', 
            'judul'  => 'required|min:5',
            'isi'    => 'required|min:10'
        ]);

        // 2. Cari data
        $berita = Berita::findOrFail($id);

        // 3. Cek gambar baru
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $path = $gambar->store('berita', 'public');
            
            // Hapus gambar lama
            Storage::disk('public')->delete('berita/' . $berita->gambar);

            $berita->update([
                'gambar'  => basename($path),
                'judul'   => $request->judul,
                'isi'     => $request->isi,
            ]);
        } else {
            $berita->update([
                'judul'   => $request->judul,
                'isi'     => $request->isi,
            ]);
        }

        // [UPDATE] Log ke Firebase
        \App\Helpers\LogHelper::catat('Mengedit berita: ' . $request->judul);

        // 4. Redirect ke 'admin.berita.index'
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $berita = Berita::findOrFail($id);

        // Hapus gambar
        Storage::disk('public')->delete('berita/' . $berita->gambar);

        // Catat judul sebelum dihapus buat log
        $judulLama = $berita->judul;

        $berita->delete();

        // [UPDATE] Log ke Firebase
        \App\Helpers\LogHelper::catat('Menghapus berita: ' . $judulLama);

        // Redirect ke 'admin.berita.index'
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }

    // Fungsi Baca Berita (Publik)
    public function baca($id)
    {
        $berita = Berita::with('user')->findOrFail($id);
        $beritaLain = Berita::where('id', '!=', $id)->latest()->take(5)->get();

        return view('berita.baca', compact('berita', 'beritaLain'));
    }
}