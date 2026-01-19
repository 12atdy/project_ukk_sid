<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\SuratAjuan;
// Import semua Model Detail
use App\Models\SuratDetailUsaha;
use App\Models\SuratDetailNikah;
use App\Models\SuratDetailTanah;
use App\Models\SuratDetailKelahiran;
use App\Models\SuratDetailKematian;
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
        $biodata = Auth::user()->biodata;
        return view('warga.surat.create', compact('biodata'));
    }

    // Menyimpan pengajuan surat ke database
    public function store(Request $request)
    {
        // 1. Validasi Umum
        $request->validate([
            'jenis_surat' => 'required|string',
            'keterangan'  => 'nullable|string',
            // Validasi lampiran (array)
            // 'lampiran' => 'required', // Opsional: kalau wajib ada lampiran, uncomment ini
        ]);

        // 2. Proses Upload Lampiran (Multiple File)
        // Hasilnya array: ['KTP' => 'path/file.jpg', 'KK' => 'path/file2.jpg']
        $dataLampiran = [];
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $namaSyarat => $file) {
                // Simpan ke storage/app/public/lampiran_surat
                $path = $file->store('lampiran_surat', 'public');
                $dataLampiran[$namaSyarat] = $path;
            }
        }

        // 3. Simpan ke Database dengan Transaksi
        DB::transaction(function () use ($request, $dataLampiran) {
            
            // A. Simpan Surat Utama (Induk)
            $surat = SuratAjuan::create([
                'user_id'       => Auth::id(),
                'jenis_surat'   => $request->jenis_surat,
                'nomor_surat'   => 'AG/'.date('Ymd').'/'.rand(1000,9999), // Generate No Surat Sementara
                'tanggal_ajuan' => now(),
                'status'        => 'menunggu',
                'keterangan'    => $request->keterangan,
                'lampiran'      => $dataLampiran, // Simpan Array JSON path file
            ]);

            // B. Simpan Detail Sesuai Jenis Surat
            switch ($request->jenis_surat) {
                
                // 1. SURAT KETERANGAN USAHA
                case 'surat_usaha':
                    SuratDetailUsaha::create([
                        'ajuan_id'     => $surat->id,
                        'nama_usaha'   => $request->nama_usaha,
                        'jenis_usaha'  => $request->jenis_usaha,
                        'alamat_usaha' => $request->alamat_usaha,
                    ]);
                    break;

                // 2. SURAT PENGANTAR NIKAH
                case 'surat_nikah':
                    SuratDetailNikah::create([
                        'ajuan_id'              => $surat->id,
                        'nama_calon_pasangan'   => $request->nama_calon_pasangan,
                        'nik_calon_pasangan'    => $request->nik_calon_pasangan,
                        'tempat_lahir_calon'    => $request->tempat_lahir_calon,
                        'tanggal_lahir_calon'   => $request->tanggal_lahir_calon,
                        'pekerjaan_calon'       => $request->pekerjaan_calon,       // Baru
                        'alamat_calon'          => $request->alamat_calon,
                        'tempat_acara_calon'    => $request->tempat_acara_calon,    // Baru
                        'status_perkawinan_calon'=> $request->status_perkawinan_calon,
                    ]);
                    break;

                // UPDATE BAGIAN INI:
                // 3. SURAT KETERANGAN TANAH (Sesuai Schema)
                case 'surat_tanah':
                    SuratDetailTanah::create([
                        'ajuan_id'          => $surat->id,
                        'biodata_id'        => null, // Biarkan null atau isi Auth::user()->biodata->id jika perlu
                        'user_id'           => null, // Ini biasanya untuk petugas verifikasi, jadi null dulu
                        'keperluan'         => $request->keterangan, // Ambil dari keterangan utama saja
                        'nomor_kohir'       => $request->nomor_kohir,
                        'lokasi_tanah'      => $request->lokasi_tanah,
                        'luas_tanah_m2'     => $request->luas_tanah_m2,
                        'batas_utara'       => $request->batas_utara,
                        'batas_timur'       => $request->batas_timur,
                        'batas_selatan'     => $request->batas_selatan,
                        'batas_barat'       => $request->batas_barat,
                        'riwayat_kepemilikan'=> $request->riwayat_kepemilikan, // Baru
                    ]);
                    break;

                // 4. SURAT KETERANGAN KELAHIRAN
                case 'surat_kelahiran':
                    SuratDetailKelahiran::create([
                        'ajuan_id'           => $surat->id,
                        'nama_bayi'          => $request->nama_bayi,
                        'jenis_kelamin_bayi' => 'Laki-laki', // Atau ambil dari request jika ada inputnya
                        'tempat_lahir_bayi'  => $request->tanggal_lahir_bayi, // Seringkali inputnya satu form
                        'tanggal_lahir_bayi' => $request->tanggal_lahir_bayi,
                        'jam_lahir'          => $request->jam_lahir ?? '00:00',
                        'anak_ke'            => 1, // Default atau ambil dari request
                        'nama_ayah'          => $request->nama_ayah,
                        'nama_ibu'           => $request->nama_ibu,
                    ]);
                    break;

                // 5. SURAT KETERANGAN KEMATIAN
                case 'surat_kematian':
                    SuratDetailKematian::create([
                        'ajuan_id'          => $surat->id,
                        'nama_almarhum'     => $request->nama_almarhum,
                        'nik_almarhum'      => $request->nik_almarhum,
                        'tanggal_meninggal' => $request->tanggal_meninggal,
                        'jam_meninggal'     => '00:00', // Default
                        'tempat_meninggal'  => $request->tempat_meninggal,
                        'sebab_meninggal'   => $request->sebab_meninggal,
                    ]);
                    break;

                // 6. SURAT PINDAH DOMISILI
                case 'surat_domisili':
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

        // 1. Kita rapikan dulu nama suratnya biar enak dibaca (misal: "surat_nikah" jadi "SURAT NIKAH")
        $namaSurat = strtoupper(str_replace('_', ' ', $request->jenis_surat));

        // 2. Panggil Helper Log ke Firebase
        \App\Helpers\LogHelper::catat("Mengajukan permohonan $namaSurat");

        return redirect()->route('surat.index')->with('success', 'Permohonan surat berhasil dikirim! Silakan tunggu verifikasi admin.');
    }

    public function cetakMandiri($id)
    {
        // 1. Cari Surat
        $surat = SuratAjuan::findOrFail($id);

        // 2. Keamanan: Pastikan yang mau cetak adalah Pemilik Surat
        if ($surat->user_id != Auth::id()) {
            abort(403, 'ANDA TIDAK BERHAK MENCETAK SURAT INI!');
        }

        // 3. Keamanan: Cek Status Harus Selesai
        if ($surat->status != 'selesai') {
            return back()->with('error', 'Surat belum selesai diproses admin.');
        }

        // 4. Tampilkan View Cetak (Kita Pinjam View Admin biar Hemat)
        // Jadi gak perlu bikin file baru lagi
        return view('admin.surat.cetak', compact('surat'));
    }

}