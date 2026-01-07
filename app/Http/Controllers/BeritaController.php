<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\LogAktivitas;
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
        // Ambil semua berita, urutkan dari yang terbaru, dan sertakan data penulisnya
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

        // 2. Simpan gambar secara eksplisit ke disk 'public'
        //    Ini akan menyimpannya di 'storage/app/public/berita'
        $path = $request->file('gambar')->store('berita', 'public');

        // 3. Buat berita baru di database
        Berita::create([
            'gambar'  => basename($path), 
            'judul'   => $request->judul,
            'isi'     => $request->isi,
            'user_id' => Auth::id()
        ]);

        LogAktivitas::create([
        'user_id' => Auth::id(),
        'aktivitas' => 'Memposting berita baru: ' . $request->judul,
        ]);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('berita.index')->with('success', 'Berita berhasil dipublikasikan!');
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
        // Cari berita berdasarkan ID
        $berita = Berita::findOrFail($id);

        // Buka view 'edit' dan kirim data berita ke sana
        return view('berita.edit', compact('berita'));
    }

    /**
     * Menyimpan perubahan dari form edit.
     */
    public function update(Request $request, string $id)
    {
        // 1. Validasi input
        $this->validate($request, [
            'gambar' => 'image|mimes:jpeg,jpg,png|max:2048', // Gambar TIDAK WAJIB diisi
            'judul'  => 'required|min:5',
            'isi'    => 'required|min:10'
        ]);

        // 2. Cari data berita
        $berita = Berita::findOrFail($id);

        // 3. Cek apakah user mengupload gambar baru
        if ($request->hasFile('gambar')) {

            // Upload gambar baru
            $gambar = $request->file('gambar');
            $path = $gambar->store('berita', 'public');

            // Hapus gambar lama
            Storage::disk('public')->delete('berita/' . $berita->gambar);

            // 4. Update data di database dengan gambar baru
            $berita->update([
                'gambar'  => basename($path),
                'judul'   => $request->judul,
                'isi'     => $request->isi,
            ]);

        } else {
            // 4. Update data di database tanpa gambar baru
            $berita->update([
                'judul'   => $request->judul,
                'isi'     => $request->isi,
            ]);
        }

        LogAktivitas::create([
        'user_id' => Auth::id(),
        'aktivitas' => 'Mengedit berita: ' . $request->judul,
        ]);

        // 5. Redirect ke halaman index
        return redirect()->route('berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 1. Cari data berita berdasarkan ID
        $berita = Berita::findOrFail($id);

        // 2. Hapus gambar lama dari folder storage
        //    (storage/app/public/berita)
        Storage::disk('public')->delete('berita/' . $berita->gambar);

        // 3. Hapus data berita dari database
        $berita->delete();

        LogAktivitas::create([
        'user_id' => Auth::id(),
        'aktivitas' => 'Menghapus berita: ' . $berita->judul,
        ]);

        // 4. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus!');
    }
    // Fungsi untuk Halaman Baca Berita (Publik)
    public function baca($id)
    {
        // Cari berita, kalau tidak ada tampilkan 404
        $berita = Berita::with('user')->findOrFail($id);

        // Ambil berita lain untuk sidebar "Berita Terbaru"
        $beritaLain = Berita::where('id', '!=', $id)->latest()->take(5)->get();

        return view('berita.baca', compact('berita', 'beritaLain'));
    }

}
