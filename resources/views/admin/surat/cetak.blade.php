<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Surat</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; }
        .header { text-align: center; border-bottom: 3px double black; padding-bottom: 10px; margin-bottom: 20px; }
        .judul { font-size: 14pt; font-weight: bold; text-decoration: underline; text-align: center; margin-bottom: 20px; }
        .nomor { text-align: center; margin-top: -20px; margin-bottom: 20px; }
        .konten { text-align: justify; margin-bottom: 20px; }
        .tabel-data td { vertical-align: top; padding: 2px 0; }
        .ttd { float: right; width: 40%; text-align: center; margin-top: 30px; }
    </style>
</head>
<body>

    <div class="header">
        <h3 style="margin:0">PEMERINTAH KABUPATEN SIDOARJO</h3>
        <h2 style="margin:0">KECAMATAN BUDURAN</h2>
        <h1 style="margin:0">DESA SIDOKERTO</h1>
        <p style="margin:0">Jl. Raya Sidokerto No. 1, Kode Pos 61252</p>
    </div>

    @php
        $judul = strtoupper(str_replace('_', ' ', $surat->jenis_surat));
        if($surat->jenis_surat == 'surat_kelahiran') $judul = "SURAT KETERANGAN KELAHIRAN";
        if($surat->jenis_surat == 'surat_kematian') $judul = "SURAT KETERANGAN KEMATIAN";
    @endphp
    
    <div class="judul">{{ $judul }}</div>
    <div class="nomor">Nomor: {{ $surat->nomor_surat }}</div>

    <div class="konten">
        
        @if($surat->jenis_surat == 'surat_kelahiran' && $surat->detailKelahiran)
            <p>Yang bertanda tangan di bawah ini Kepala Desa Sidokerto, Kecamatan Buduran, Kabupaten Sidoarjo, menerangkan dengan sebenarnya bahwa pada:</p>
            
            <table class="tabel-data" width="100%" style="margin-left: 20px;">
                <tr><td width="150">Hari</td><td>: {{ \Carbon\Carbon::parse($surat->detailKelahiran->tanggal_lahir_bayi)->translatedFormat('l') }}</td></tr>
                <tr><td>Tanggal</td><td>: {{ \Carbon\Carbon::parse($surat->detailKelahiran->tanggal_lahir_bayi)->translatedFormat('d F Y') }}</td></tr>
                <tr><td>Pukul</td><td>: {{ $surat->detailKelahiran->jam_lahir ?? '-' }} WIB</td></tr>
                <tr><td>Tempat Kelahiran</td><td>: {{ $surat->detailKelahiran->tempat_lahir_bayi }}</td></tr>
            </table>

            <p>Telah lahir seorang anak {{ $surat->detailKelahiran->jenis_kelamin_bayi }}:</p>

            <table class="tabel-data" width="100%" style="margin-left: 20px;">
                <tr><td width="150">Bernama</td><td>: <strong>{{ $surat->detailKelahiran->nama_bayi }}</strong></td></tr>
                <tr><td>Anak ke-</td><td>: {{ $surat->detailKelahiran->anak_ke }}</td></tr>
                <tr><td>Dari seorang Ibu</td><td>: {{ $surat->detailKelahiran->nama_ibu }}</td></tr>
                <tr><td>Istri dari</td><td>: {{ $surat->detailKelahiran->nama_ayah }}</td></tr>
                <tr><td>Alamat</td><td>: {{ $surat->user->biodata->alamat ?? 'Desa Sidokerto' }}</td></tr>
            </table>

            <p>Surat keterangan ini dibuat atas dasar yang sebenarnya.</p>

        @elseif($surat->jenis_surat == 'surat_kematian' && $surat->detailKematian)
            <p>Yang bertanda tangan di bawah ini Kepala Desa Sidokerto, Kecamatan Buduran, Kabupaten Sidoarjo, menerangkan bahwa:</p>
            
            <table class="tabel-data" width="100%" style="margin-left: 20px;">
                <tr><td width="150">Nama</td><td>: <strong>{{ $surat->detailKematian->nama_almarhum }}</strong></td></tr>
                <tr><td>NIK</td><td>: {{ $surat->detailKematian->nik_almarhum ?? '-' }}</td></tr>
                <tr><td>Jenis Kelamin</td><td>: {{ $surat->detailKematian->jenis_kelamin ?? '-' }}</td></tr>
                <tr><td>Alamat</td><td>: {{ $surat->user->biodata->alamat ?? '-' }}</td></tr>
            </table>

            <p>Telah meninggal dunia pada:</p>

            <table class="tabel-data" width="100%" style="margin-left: 20px;">
                <tr><td width="150">Hari/Tanggal</td><td>: {{ \Carbon\Carbon::parse($surat->detailKematian->tanggal_meninggal)->translatedFormat('l, d F Y') }}</td></tr>
                <tr><td>Pukul</td><td>: {{ $surat->detailKematian->jam_meninggal ?? '-' }} WIB</td></tr>
                <tr><td>Tempat Meninggal</td><td>: {{ $surat->detailKematian->tempat_meninggal }}</td></tr>
                <tr><td>Penyebab</td><td>: {{ $surat->detailKematian->sebab_meninggal }}</td></tr>
            </table>

            <p>Demikian surat keterangan kematian ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>

        @else
            <p>Yang bertanda tangan di bawah ini Kepala Desa Sidokerto, Kecamatan Buduran, Kabupaten Sidoarjo, menerangkan bahwa:</p>

            <table class="tabel-data" width="100%" style="margin-left: 20px;">
                <tr><td width="150">Nama Lengkap</td><td>: <strong>{{ $surat->user->name }}</strong></td></tr>
                <tr><td>NIK</td><td>: {{ $surat->user->biodata->nik ?? '-' }}</td></tr>
                <tr><td>Tempat/Tgl Lahir</td><td>: {{ $surat->user->biodata->tempat_lahir ?? '-' }}, {{ $surat->user->biodata->tanggal_lahir ?? '-' }}</td></tr>
                <tr><td>Jenis Kelamin</td><td>: {{ $surat->user->biodata->jenis_kelamin ?? '-' }}</td></tr>
                <tr><td>Alamat</td><td>: {{ $surat->user->biodata->alamat ?? '-' }}</td></tr>
            </table>

            <p>Orang tersebut di atas adalah benar-benar warga Desa Sidokerto dan surat ini dibuat untuk keperluan:</p>
            
            <div style="border: 1px solid #000; padding: 10px; margin: 10px 0;">
                @if($surat->jenis_surat == 'surat_usaha')
                    <strong>Keterangan Usaha:</strong><br>
                    Memiliki usaha bernama "{{ $surat->detailUsaha->nama_usaha }}" yang bergerak di bidang {{ $surat->detailUsaha->jenis_usaha }}, berlokasi di {{ $surat->detailUsaha->alamat_usaha }}.
                
                @elseif($surat->jenis_surat == 'surat_nikah')
                    <strong>Pengantar Nikah:</strong><br>
                    Akan melangsungkan pernikahan dengan {{ $surat->detailNikah->nama_calon_pasangan }} (NIK: {{ $surat->detailNikah->nik_calon_pasangan }}).
                
                @elseif($surat->jenis_surat == 'surat_tanah')
                    <strong>Keterangan Tanah:</strong><br>
                    Pemilik tanah seluas {{ $surat->detailTanah->luas_tanah_m2 }} m2 yang berlokasi di {{ $surat->detailTanah->lokasi_tanah }}.
                @else
                    <p>Keterangan sesuai data yang diajukan.</p>
                @endif
            </div>

            <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
        @endif

    </div>

    <div class="ttd">
        Sidokerto, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
        Kepala Desa Sidokerto
        <br><br><br><br>
        <strong>(Nama Kepala Desa)</strong>
    </div>

</body>
</html>