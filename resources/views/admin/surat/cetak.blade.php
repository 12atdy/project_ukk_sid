<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Surat - {{ $surat->nomor_surat }}</title>
    <style>
        body { 
            font-family: 'Times New Roman', Times, serif; 
            font-size: 12pt; 
            line-height: 1.5; 
            margin: 0; 
            padding: 20px; 
            color: #000;
        }

        /* --- GAYA KOP SURAT --- */
        .kop-table { 
            width: 100%; 
            border-bottom: 4px double #000; 
            padding-bottom: 10px; 
            margin-bottom: 25px; 
        }
        .kop-table td { vertical-align: middle; }
        .td-logo { width: 100px; text-align: left; }
        .td-text { text-align: center; }
        
        .header-pem { font-size: 14pt; font-weight: bold; margin: 0; }
        .header-kec { font-size: 16pt; font-weight: bold; margin: 0; text-transform: uppercase; }
        .header-des { font-size: 20pt; font-weight: bold; margin: 0; text-transform: uppercase; }
        .header-alm { font-size: 10pt; font-style: italic; margin: 0; }

        /* GAYA KONTEN */
        .judul { font-size: 14pt; font-weight: bold; text-decoration: underline; text-align: center; text-transform: uppercase; margin-bottom: 5px; }
        .nomor { text-align: center; margin-bottom: 20px; font-size: 12pt; }
        .konten { text-align: justify; margin-bottom: 20px; min-height: 300px; }
        .tabel-data td { vertical-align: top; padding: 2px 0; }
        
        /* GAYA DOMISILI */
        .kotak-pindah {
            border: 2px solid #000;
            padding: 15px;
            margin: 15px 0;
            background-color: #fff;
        }
        .panah-pindah { font-size: 30px; font-weight: bold; }

        /* --- CSS PRINT --- */
        @media print {
            .no-print { display: none !important; }
            @page { margin: 2cm; size: auto; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px; text-align: right; padding: 10px; background: #eee; border-bottom: 1px solid #ddd;">
        <button onclick="window.history.back()" style="padding: 5px 15px; cursor: pointer; border:1px solid #aaa;">&larr; Kembali</button>
        <button onclick="window.print()" style="padding: 5px 15px; cursor: pointer; font-weight: bold; background: #000; color: #fff; border: none; margin-left:10px;">Cetak Surat</button>
    </div>

    <table class="kop-table">
        <tr>
            <td class="td-logo">
                @php
                    $path = public_path('images/logo-sidokerto.png');
                    $base64 = '';
                    if (file_exists($path)) {
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    }
                @endphp

                @if($base64)
                   <img src="{{ $base64 }}" alt="Logo" style="width: 90px; height: auto;">
                @else
                    <span style="color:red; font-size:10px;">Logo Not Found</span>
                @endif
            </td>
            <td class="td-text">
                <h3 class="header-pem">PEMERINTAH KABUPATEN SIDOARJO</h3>
                <h2 class="header-kec">KECAMATAN BUDURAN</h2>
                <h1 class="header-des">DESA SIDOKERTO</h1>
                <p class="header-alm">Jl. Raya Sidokerto No. 1, Buduran, Sidoarjo - Jawa Timur 61252</p>
            </td>
        </tr>
    </table>

    @php
        $judul = str_replace('_', ' ', $surat->jenis_surat);
        if($surat->jenis_surat == 'surat_domisili') $judul = "SURAT KETERANGAN PINDAH DOMISILI";
    @endphp
    
    <div class="judul">{{ $judul }}</div>
    <div class="nomor">Nomor: {{ $surat->nomor_surat }}</div>

    <div class="konten">

        {{-- === LOGIKA 1: SURAT DOMISILI === --}}
        @if($surat->jenis_surat == 'surat_domisili' && $surat->detailDomisili)
            
            <p>Yang bertanda tangan di bawah ini Kepala Desa Sidokerto, Kecamatan Buduran, Kabupaten Sidoarjo, menerangkan permohonan pindah penduduk WNI:</p>

            <table class="tabel-data" width="100%" style="margin-left: 20px; margin-bottom: 15px;">
                <tr><td width="160">Nama Lengkap</td><td>: <strong>{{ $surat->user->name }}</strong></td></tr>
                <tr><td>NIK</td><td>: {{ $surat->user->biodata->nik ?? '-' }}</td></tr>
                <tr><td>Tempat, Tgl Lahir</td><td>: {{ $surat->user->biodata->tempat_lahir ?? '-' }}, {{ $surat->user->biodata->tanggal_lahir ?? '-' }}</td></tr>
                <tr><td>Pekerjaan</td><td>: {{ $surat->user->biodata->pekerjaan ?? '-' }}</td></tr>
                <tr><td>Agama</td><td>: {{ $surat->user->biodata->agama ?? '-' }}</td></tr>
            </table>

            <p>Bahwa orang tersebut benar-benar mengajukan permohonan <strong>PINDAH TEMPAT TINGGAL</strong> dengan rincian:</p>

            <div class="kotak-pindah">
                <table width="100%">
                    <tr>
                        <td width="45%" style="border-right: 1px dashed #999; padding-right: 10px;">
                            <strong style="text-decoration: underline;">DAERAH ASAL</strong><br><br>
                            {{ $surat->detailDomisili->alamat_asal }}
                        </td>
                        <td width="10%" align="center"><span class="panah-pindah">&#10142;</span></td>
                        <td width="45%" style="padding-left: 10px;">
                            <strong style="text-decoration: underline;">DAERAH TUJUAN</strong><br><br>
                            {{ $surat->detailDomisili->alamat_tujuan }}
                        </td>
                    </tr>
                </table>
                <hr style="border-top: 1px solid #000; margin: 10px 0;">
                <p style="margin:0;"><strong>Alasan:</strong> {{ $surat->detailDomisili->alasan_pindah }} (Pengikut: {{ $surat->detailDomisili->jumlah_pengikut }} org)</p>
            </div>

            <p>Demikian surat keterangan pindah ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>

        {{-- === LOGIKA 2: SURAT KELAHIRAN === --}}
        @elseif($surat->jenis_surat == 'surat_kelahiran' && $surat->detailKelahiran)
            <p>Yang bertanda tangan di bawah ini Kepala Desa Sidokerto, Kecamatan Buduran, Kabupaten Sidoarjo, menerangkan dengan sebenarnya bahwa pada:</p>
            
            <table class="tabel-data" width="100%" style="margin-left: 20px;">
                <tr><td width="160">Hari/Tanggal</td><td>: {{ \Carbon\Carbon::parse($surat->detailKelahiran->tanggal_lahir_bayi)->translatedFormat('l, d F Y') }}</td></tr>
                <tr><td>Pukul</td><td>: {{ $surat->detailKelahiran->jam_lahir ?? '-' }} WIB</td></tr>
                <tr><td>Tempat Kelahiran</td><td>: {{ $surat->detailKelahiran->tempat_lahir_bayi }}</td></tr>
            </table>

            <p>Telah lahir seorang anak {{ $surat->detailKelahiran->jenis_kelamin_bayi }}:</p>

            <table class="tabel-data" width="100%" style="margin-left: 20px;">
                <tr><td width="160">Bernama</td><td>: <strong>{{ $surat->detailKelahiran->nama_bayi }}</strong></td></tr>
                <tr><td>Anak ke-</td><td>: {{ $surat->detailKelahiran->anak_ke }}</td></tr>
                <tr><td>Dari Ibu</td><td>: {{ $surat->detailKelahiran->nama_ibu }}</td></tr>
                <tr><td>Istri dari</td><td>: {{ $surat->detailKelahiran->nama_ayah }}</td></tr>
                <tr><td>Alamat</td><td>: {{ $surat->user->biodata->alamat ?? 'Desa Sidokerto' }}</td></tr>
            </table>

            <p>Surat keterangan ini dibuat atas dasar yang sebenarnya.</p>

        {{-- === LOGIKA 3: SURAT KEMATIAN === --}}
        @elseif($surat->jenis_surat == 'surat_kematian' && $surat->detailKematian)
            <p>Yang bertanda tangan di bawah ini Kepala Desa Sidokerto, Kecamatan Buduran, Kabupaten Sidoarjo, menerangkan bahwa:</p>
            
            <table class="tabel-data" width="100%" style="margin-left: 20px;">
                <tr><td width="160">Nama</td><td>: <strong>{{ $surat->detailKematian->nama_almarhum }}</strong></td></tr>
                <tr><td>NIK</td><td>: {{ $surat->detailKematian->nik_almarhum ?? '-' }}</td></tr>
                <tr><td>Alamat Terakhir</td><td>: {{ $surat->user->biodata->alamat ?? '-' }}</td></tr>
            </table>

            <p>Telah meninggal dunia pada:</p>

            <table class="tabel-data" width="100%" style="margin-left: 20px;">
                <tr><td width="160">Hari/Tanggal</td><td>: {{ \Carbon\Carbon::parse($surat->detailKematian->tanggal_meninggal)->translatedFormat('l, d F Y') }}</td></tr>
                <tr><td>Pukul</td><td>: {{ $surat->detailKematian->jam_meninggal ?? '-' }} WIB</td></tr>
                <tr><td>Tempat Meninggal</td><td>: {{ $surat->detailKematian->tempat_meninggal }}</td></tr>
                <tr><td>Penyebab</td><td>: {{ $surat->detailKematian->sebab_meninggal }}</td></tr>
            </table>

            <p>Demikian surat keterangan kematian ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

        {{-- === LOGIKA 4: SURAT UMUM (USAHA, TANAH, NIKAH) === --}}
        @else
            <p>Yang bertanda tangan di bawah ini Kepala Desa Sidokerto, Kecamatan Buduran, Kabupaten Sidoarjo, menerangkan bahwa:</p>

            <table class="tabel-data" width="100%" style="margin-left: 20px;">
                <tr><td width="160">Nama Lengkap</td><td>: <strong>{{ $surat->user->name }}</strong></td></tr>
                <tr><td>NIK</td><td>: {{ $surat->user->biodata->nik ?? '-' }}</td></tr>
                <tr><td>TTL</td><td>: {{ $surat->user->biodata->tempat_lahir ?? '-' }}, {{ $surat->user->biodata->tanggal_lahir ?? '-' }}</td></tr>
                <tr><td>Pekerjaan</td><td>: {{ $surat->user->biodata->pekerjaan ?? '-' }}</td></tr>
                <tr><td>Alamat</td><td>: {{ $surat->user->biodata->alamat ?? '-' }}</td></tr>
            </table>

            <p>Orang tersebut adalah benar-benar warga Desa Sidokerto dan surat ini dibuat untuk keperluan:</p>
            
            <div style="border: 1px solid #000; padding: 10px; margin: 10px 0;">
                @if($surat->jenis_surat == 'surat_usaha' && $surat->detailUsaha)
                    <strong>Keterangan Usaha:</strong><br>
                    Memiliki usaha "<strong>{{ $surat->detailUsaha->nama_usaha }}</strong>" ({{ $surat->detailUsaha->jenis_usaha }}) di {{ $surat->detailUsaha->alamat_usaha }}.
                
                @elseif($surat->jenis_surat == 'surat_nikah' && $surat->detailNikah)
                    <strong>Pengantar Nikah:</strong><br>
                    Akan menikah dengan <strong>{{ $surat->detailNikah->nama_calon_pasangan }}</strong> (NIK: {{ $surat->detailNikah->nik_calon_pasangan }}).
                
                @elseif($surat->jenis_surat == 'surat_tanah' && $surat->detailTanah)
                    <strong>Keterangan Tanah:</strong><br>
                    Pemilik tanah seluas {{ $surat->detailTanah->luas_tanah_m2 }} m2 di {{ $surat->detailTanah->lokasi_tanah }}. (Kohir: {{ $surat->detailTanah->nomor_kohir ?? '-' }})
                @else
                    <p>Keterangan sesuai data yang diajukan.</p>
                @endif
            </div>

            <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
        @endif

    </div>

    <div style="margin-top: 20px;">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 60%;"></td> <td style="width: 40%; text-align: center;">
                    <p style="margin-bottom: 10px;">
                        Dikeluarkan di: Sidokerto<br>
                        Pada Tanggal: {{ \Carbon\Carbon::parse($surat->updated_at)->translatedFormat('d F Y') }}<br>
                        <strong>KEPALA DESA SIDOKERTO</strong>
                    </p>
                    
                    <div style="margin: 10px auto;">
                        @php
                            $urlValidasi = route('cek.surat', $surat->id);
                        @endphp
                        {{-- QR Code (Render as Image Base64 agar aman saat print) --}}
                        <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(100)->generate($urlValidasi)) }}" alt="QR Validasi">
                    </div>

                    <p style="text-decoration: underline; font-weight: bold; margin-top: 10px;">
                        H. ABDUL AZIZ, S.E.
                    </p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>