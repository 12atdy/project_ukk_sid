<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratAjuan;
use App\Models\SuratDetailUsaha;
use App\Models\SuratDetailNikah;
use App\Models\SuratDetailTanah;
use App\Models\SuratDetailKelahiran;
use App\Models\SuratDetailKematian;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\SuratDetailDomisili;

class SuratAjuanController extends Controller
{
    // Menampilkan riwayat surat saya
    public function index()
    {
        $suratSaya = SuratAjuan::where('user_id', Auth::id())->latest()->get();
        return view('warga.surat.index', compact('suratSaya'));
    }

    // Menampilkan form pengajuan surat baru
    public function create()
    {
        // Ambil data biodata dari user yang sedang login untuk auto-fill
        $biodata = Auth::user()->biodata;
        
        return view('warga.surat.create', compact('biodata'));
    }

    // Menyimpan pengajuan surat ke database
    public function store(Request $request)
    {
        // 1. Validasi Umum (Wajib buat semua jenis surat)
        $request->validate([
            'jenis_surat'   => 'required|string',
            'keterangan'    => 'nullable|string',
            'foto_lampiran' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib Upload Foto, Max 2MB
        ]);

        // 2. Proses Upload Foto Lampiran
        $pathFoto = null;
        if ($request->hasFile('foto_lampiran')) {
            // Simpan ke folder 'storage/app/public/lampiran-surat'
            // Pastikan sudah menjalankan: php artisan storage:link
            $pathFoto = $request->file('foto_lampiran')->store('lampiran-surat', 'public');
        }

        // 3. Simpan ke Database dengan Transaksi
        // Gunakan DB::transaction agar data konsisten (Atomicity)
        DB::transaction(function () use ($request, $pathFoto) {
            
            // A. Simpan Surat Utama (Induk)
            $surat = SuratAjuan::create([
                'user_id'       => Auth::id(),
                'jenis_surat'   => $request->jenis_surat,
                'tanggal_ajuan' => now(),
                'status'        => 'menunggu',
                'keterangan'    => $request->keterangan,
                'foto_lampiran' => basename($pathFoto), // Simpan nama filenya saja (misal: foto.jpg)
            ]);

            // B. Simpan Detail Sesuai Jenis Surat
            switch ($request->jenis_surat) {
                
                // 1. SURAT KETERANGAN USAHA
                case 'surat_usaha':
                    $request->validate([
                        'nama_usaha' => 'required',
                        'jenis_usaha' => 'required',
                        'alamat_usaha' => 'required',
                    ]);
                    SuratDetailUsaha::create([
                        'ajuan_id'      => $surat->id,
                        'nama_usaha'    => $request->nama_usaha,
                        'jenis_usaha'   => $request->jenis_usaha,
                        'alamat_usaha'  => $request->alamat_usaha,
                    ]);
                    break;

                // 2. SURAT PENGANTAR NIKAH
                case 'surat_nikah':
                    $request->validate(['nama_calon_pasangan' => 'required']);
                    SuratDetailNikah::create([
                        'ajuan_id'                => $surat->id,
                        'nama_calon_pasangan'     => $request->nama_calon_pasangan,
                        'nik_calon_pasangan'      => $request->nik_calon_pasangan,
                        'tempat_lahir_calon'      => $request->tempat_lahir_calon,
                        'tanggal_lahir_calon'     => $request->tanggal_lahir_calon,
                        'status_perkawinan_calon' => $request->status_perkawinan_calon,
                        'alamat_calon'            => $request->alamat_calon,
                    ]);
                    break;

                // 3. SURAT KETERANGAN TANAH
                case 'surat_tanah':
                    $request->validate(['lokasi_tanah' => 'required']);
                    SuratDetailTanah::create([
                        'ajuan_id'      => $surat->id,
                        'lokasi_tanah'  => $request->lokasi_tanah,
                        'luas_tanah_m2' => $request->luas_tanah_m2,
                        'nomor_kohir'   => $request->nomor_kohir,
                        'batas_utara'   => $request->batas_utara,
                        'batas_timur'   => $request->batas_timur,
                        'batas_selatan' => $request->batas_selatan,
                        'batas_barat'   => $request->batas_barat,
                    ]);
                    break;

                // 4. SURAT KETERANGAN KELAHIRAN
                case 'surat_kelahiran':
                    $request->validate(['nama_bayi' => 'required']);
                    SuratDetailKelahiran::create([
                        'ajuan_id'           => $surat->id,
                        'nama_bayi'          => $request->nama_bayi,
                        'jenis_kelamin_bayi' => $request->jenis_kelamin_bayi,
                        'tempat_lahir_bayi'  => $request->tempat_lahir_bayi,
                        'tanggal_lahir_bayi' => $request->tanggal_lahir_bayi,
                        'jam_lahir'          => $request->jam_lahir,
                        'anak_ke'            => $request->anak_ke,
                        'nama_ayah'          => $request->nama_ayah,
                        'nama_ibu'           => $request->nama_ibu,
                    ]);
                    break;

                // 5. SURAT KETERANGAN KEMATIAN
                case 'surat_kematian':
                    $request->validate(['nama_almarhum' => 'required']);
                    SuratDetailKematian::create([
                        'ajuan_id'          => $surat->id,
                        'nama_almarhum'     => $request->nama_almarhum,
                        'nik_almarhum'      => $request->nik_almarhum,
                        'tanggal_meninggal' => $request->tanggal_meninggal,
                        'jam_meninggal'     => $request->jam_meninggal,
                        'tempat_meninggal'  => $request->tempat_meninggal,
                        'sebab_meninggal'   => $request->sebab_meninggal,
                        'nama_pelapor'      => $request->nama_pelapor,
                        'hubungan_pelapor'  => $request->hubungan_pelapor,
                    ]);
                    break;

                    // 6. SURAT PINDAH DOMISILI
                case 'surat_domisili':
                    $request->validate([
                        'alamat_asal' => 'required',
                        'alamat_tujuan' => 'required',
                    ]);
                    SuratDetailDomisili::create([
                        'ajuan_id'      => $surat->id,
                        'alamat_asal'   => $request->alamat_asal,
                        'alamat_tujuan' => $request->alamat_tujuan,
                        'alasan_pindah' => $request->alasan_pindah,
                        'jumlah_pengikut'=> $request->jumlah_pengikut,
                    ]);
                    break;
            }

        });

        // 4. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('surat.index')->with('success', 'Permohonan surat berhasil dikirim! Silakan tunggu verifikasi admin.');
    }
}