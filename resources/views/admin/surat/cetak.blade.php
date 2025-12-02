<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Surat - {{ $surat->nomor_surat }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; }
        .header { text-align: center; border-bottom: 3px double black; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { width: 80px; height: auto; position: absolute; left: 0; top: 0; }
        .judul { font-size: 14pt; font-weight: bold; text-decoration: underline; text-align: center; text-transform: uppercase; margin-bottom: 5px; }
        .nomor { text-align: center; margin-bottom: 20px; }
        .konten { text-align: justify; margin-bottom: 20px; }
        .tabel-data td { vertical-align: top; padding: 2px 0; }
        .ttd { float: right; width: 40%; text-align: center; margin-top: 30px; }
        
        /* Style Khusus Kotak Pindah */
        .kotak-pindah {
            border: 2px solid #000;
            padding: 15px;
            margin: 15px 0;
            background-color: #f9f9f9;
        }
        .panah-pindah {
            font-size: 30px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="header">
        <!-- <img src="{{ public_path('images/logo-sidokerto.png') }}" class="logo"> -->
        <h3 style="margin:0">PEMERINTAH KABUPATEN SIDOARJO</h3>
        <h2 style="margin:0">KECAMATAN BUDURAN</h2>
        <h1 style="margin:0">DESA SIDOKERTO</h1>
        <p style="margin:0">Jl. Raya Sidokerto No. 1, Kode Pos 61252</p>
    </div>

    <!-- JUDUL & NOMOR -->
    @php
        $judul = str_replace('_', ' ', $surat->jenis_surat);
        if($surat->jenis_surat == 'surat_domisili') $judul = "SURAT KETERANGAN PINDAH DOMISILI";
    @endphp
    
    <div class="judul">{{ $judul }}</div>
    <div class="nomor">Nomor: {{ $surat->nomor_surat }}</div>

    <div class="konten">

        <!-- ================================================== -->
        <!-- 1. FORMAT KHUSUS PINDAH DOMISILI (YANG KAMU MINTA) -->
        <!-- ================================================== -->
        @if($surat->jenis_surat == 'surat_domisili' && $surat->detailDomisili)
            
            <p>Yang bertanda tangan di bawah ini Kepala Desa Sidokerto, Kecamatan Buduran, Kabupaten Sidoarjo, menerangkan permohonan pindah penduduk WNI:</p>

            <!-- Data Diri Pemohon -->
            <table class="tabel-data" width="100%" style="margin-left: 20px; margin-bottom: 15px;">
                <tr><td width="160">Nama Lengkap</td><td>: <strong>{{ $surat->user->name }}</strong></td></tr>
                <tr><td>NIK</td><td>: {{ $surat->user->biodata->nik ?? '-' }}</td></tr>
                <tr><td>Tempat, Tgl Lahir</td><td>: {{ $surat->user->biodata->tempat_lahir ?? '-' }}, {{ $surat->user->biodata->tanggal_lahir ?? '-' }}</td></tr>
                <tr><td>Pekerjaan</td><td>: {{ $surat->user->biodata->pekerjaan ?? '-' }}</td></tr>
                <tr><td>Agama</td><td>: {{ $surat->user->biodata->agama ?? '-' }}</td></tr>
                <tr><td>Status Perkawinan</td><td>: {{ $surat->user->biodata->status_perkawinan ?? '-' }}</td></tr>
            </table>

            <p>Bahwa orang tersebut benar-benar mengajukan permohonan <strong>PINDAH TEMPAT TINGGAL</strong> dengan rincian sebagai berikut:</p>

            <!-- VISUALISASI PERPINDAHAN (KOTA A -> KOTA B) -->
            <div class="kotak-pindah">
                <table width="100%">
                    <tr>
                        <!-- ALAMAT ASAL -->
                        <td width="45%" style="border-right: 1px dashed #999; padding-right: 10px;">
                            <strong style="text-decoration: underline;">DAERAH ASAL (LAMA)</strong><br>
                            <br>
                            {{ $surat->detailDomisili->alamat_asal }}
                        </td>
                        
                        <!-- PANAH -->
                        <td width="10%" align="center" valign="middle">
                            <span class="panah-pindah">&#10142;</span> <!-- Simbol Panah Kanan -->
                        </td>

                        <!-- ALAMAT TUJUAN -->
                        <td width="45%" style="padding-left: 10px;">
                            <strong style="text-decoration: underline;">DAERAH TUJUAN (BARU)</strong><br>
                            <br>
                            {{ $surat->detailDomisili->alamat_tujuan }}
                        </td>
                    </tr>
                </table>
                
                <hr style="border-top: 1px solid #000; margin: 10px 0;">
                
                <table width="100%">
                    <tr>
                        <td width="50%"><strong>Alasan Pindah:</strong> {{ $surat->detailDomisili->alasan_pindah }}</td>
                        <td width="50%"><strong>Jumlah Pengikut:</strong> {{ $surat->detailDomisili->jumlah_pengikut }} Orang</td>
                    </tr>
                </table>
            </div>

            <p>Demikian surat keterangan pindah ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>

        <!-- ================================================== -->
        <!-- 2. FORMAT KHUSUS KELAHIRAN (YANG KEMARIN) -->
        <!-- ================================================== -->
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

        <!-- ================================================== -->
        <!-- 3. FORMAT KHUSUS KEMATIAN -->
        <!-- ================================================== -->
        @elseif($surat->jenis_surat == 'surat_kematian' && $surat->detailKematian)
            <p>Yang bertanda tangan di bawah ini Kepala Desa Sidokerto, Kecamatan Buduran, Kabupaten Sidoarjo, menerangkan bahwa:</p>
            
            <table class="tabel-data" width="100%" style="margin-left: 20px;">
                <tr><td width="160">Nama</td><td>: <strong>{{ $surat->detailKematian->nama_almarhum }}</strong></td></tr>
                <tr><td>NIK</td><td>: {{ $surat->detailKematian->nik_almarhum ?? '-' }}</td></tr>
                <tr><td>Jenis Kelamin</td><td>: {{ $surat->detailKematian->jenis_kelamin ?? '-' }}</td></tr>
                <tr><td>Alamat</td><td>: {{ $surat->user->biodata->alamat ?? '-' }}</td></tr>
            </table>

            <p>Telah meninggal dunia pada:</p>

            <table class="tabel-data" width="100%" style="margin-left: 20px;">
                <tr><td width="160">Hari/Tanggal</td><td>: {{ \Carbon\Carbon::parse($surat->detailKematian->tanggal_meninggal)->translatedFormat('l, d F Y') }}</td></tr>
                <tr><td>Pukul</td><td>: {{ $surat->detailKematian->jam_meninggal ?? '-' }} WIB</td></tr>
                <tr><td>Tempat Meninggal</td><td>: {{ $surat->detailKematian->tempat_meninggal }}</td></tr>
                <tr><td>Penyebab</td><td>: {{ $surat->detailKematian->sebab_meninggal }}</td></tr>
            </table>

            <p>Demikian surat keterangan kematian ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

        <!-- ================================================== -->
        <!-- 4. FORMAT UMUM (USAHA, NIKAH, TANAH) -->
        <!-- ================================================== -->
        @else
            <p>Yang bertanda tangan di bawah ini Kepala Desa Sidokerto, Kecamatan Buduran, Kabupaten Sidoarjo, menerangkan bahwa:</p>

            <table class="tabel-data" width="100%" style="margin-left: 20px;">
                <tr><td width="160">Nama Lengkap</td><td>: <strong>{{ $surat->user->name }}</strong></td></tr>
                <tr><td>NIK</td><td>: {{ $surat->user->biodata->nik ?? '-' }}</td></tr>
                <tr><td>Tempat/Tgl Lahir</td><td>: {{ $surat->user->biodata->tempat_lahir ?? '-' }}, {{ $surat->user->biodata->tanggal_lahir ?? '-' }}</td></tr>
                <tr><td>Jenis Kelamin</td><td>: {{ $surat->user->biodata->jenis_kelamin ?? '-' }}</td></tr>
                <tr><td>Pekerjaan</td><td>: {{ $surat->user->biodata->pekerjaan ?? '-' }}</td></tr>
                <tr><td>Alamat</td><td>: {{ $surat->user->biodata->alamat ?? '-' }}</td></tr>
            </table>

            <p>Orang tersebut di atas adalah benar-benar warga Desa Sidokerto dan surat ini dibuat untuk keperluan:</p>
            
            <div style="border: 1px solid #000; padding: 10px; margin: 10px 0;">
                @if($surat->jenis_surat == 'surat_usaha')
                    <strong>Keterangan Usaha:</strong><br>
                    Memiliki usaha bernama "<strong>{{ $surat->detailUsaha->nama_usaha }}</strong>" yang bergerak di bidang {{ $surat->detailUsaha->jenis_usaha }}, berlokasi di {{ $surat->detailUsaha->alamat_usaha }}.
                
                @elseif($surat->jenis_surat == 'surat_nikah')
                    <strong>Pengantar Nikah:</strong><br>
                    Akan melangsungkan pernikahan dengan <strong>{{ $surat->detailNikah->nama_calon_pasangan }}</strong> (NIK: {{ $surat->detailNikah->nik_calon_pasangan }}).
                
                @elseif($surat->jenis_surat == 'surat_tanah')
                    <strong>Keterangan Tanah:</strong><br>
                    Pemilik tanah seluas {{ $surat->detailTanah->luas_tanah_m2 }} m2 yang berlokasi di {{ $surat->detailTanah->lokasi_tanah }}.<br>
                    Nomor Kohir: {{ $surat->detailTanah->nomor_kohir ?? '-' }}
                @else
                    <p>Keterangan sesuai data yang diajukan.</p>
                @endif
            </div>

            <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
        @endif

    </div>

    <!-- TANDA TANGAN -->
    <div class="ttd">
        Sidokerto, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
        Kepala Desa Sidokerto
        <br><br><br><br>
        <strong>(Nama Kepala Desa)</strong>
    </div>

</body>
</html>