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

class SuratAjuanController extends Controller
{
    public function index()
    {
        $suratSaya = SuratAjuan::where('user_id', Auth::id())->latest()->get();
        return view('warga.surat.index', compact('suratSaya'));
    }

    // [DIPERBARUI] Kirim data User & Biodata ke Form
    public function create()
    {
        $user = Auth::user();
        $biodata = $user->biodata; // Ambil data biodata dari user yang login
        
        return view('warga.surat.create', compact('user', 'biodata'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_surat' => 'required|string',
            'keterangan'  => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            
            $surat = SuratAjuan::create([
                'user_id'       => Auth::id(),
                'jenis_surat'   => $request->jenis_surat,
                'tanggal_ajuan' => now(),
                'status'        => 'menunggu',
                'keterangan'    => $request->keterangan,
            ]);

            switch ($request->jenis_surat) {
                case 'surat_usaha':
                    $request->validate(['nama_usaha' => 'required']);
                    SuratDetailUsaha::create([
                        'ajuan_id'      => $surat->id,
                        'nama_usaha'    => $request->nama_usaha,
                        'jenis_usaha'   => $request->jenis_usaha,
                        'alamat_usaha'  => $request->alamat_usaha,
                    ]);
                    break;

                case 'surat_nikah':
                    $request->validate(['nama_calon_pasangan' => 'required']);
                    SuratDetailNikah::create([
                        'ajuan_id'            => $surat->id,
                        'nama_calon_pasangan' => $request->nama_calon_pasangan,
                        'nik_calon_pasangan'  => $request->nik_calon_pasangan,
                        'tempat_lahir_calon'  => $request->tempat_lahir_calon,
                        'tanggal_lahir_calon' => $request->tanggal_lahir_calon,
                        'pekerjaan_calon'     => $request->pekerjaan_calon,
                        'alamat_calon'        => $request->alamat_calon,
                        'status_perkawinan_calon' => $request->status_perkawinan_calon,
                    ]);
                    break;

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

                case 'surat_kelahiran':
                    $request->validate(['nama_bayi' => 'required', 'nama_ibu' => 'required']);
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
                        'hubungan_pelapor'   => $request->hubungan_pelapor ?? 'Orang Tua',
                    ]);
                    break;

                case 'surat_kematian':
                    $request->validate(['nama_almarhum' => 'required', 'tanggal_meninggal' => 'required']);
                    SuratDetailKematian::create([
                        'ajuan_id'               => $surat->id,
                        'nama_almarhum'          => $request->nama_almarhum,
                        'nik_almarhum'           => $request->nik_almarhum,
                        'bin_binti'              => $request->bin_binti,
                        'tempat_lahir_almarhum'  => $request->tempat_lahir_almarhum,
                        'tanggal_lahir_almarhum' => $request->tanggal_lahir_almarhum,
                        'tanggal_meninggal'      => $request->tanggal_meninggal,
                        'jam_meninggal'          => $request->jam_meninggal,
                        'tempat_meninggal'       => $request->tempat_meninggal,
                        'sebab_meninggal'        => $request->sebab_meninggal,
                        'nama_pelapor'           => $request->nama_pelapor,
                        'hubungan_pelapor'       => $request->hubungan_pelapor,
                    ]);
                    break;
            }
        });

        return redirect()->route('surat.index')->with('success', 'Permohonan surat berhasil dikirim!');
    }
}