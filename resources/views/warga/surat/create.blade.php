@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-envelope-open-text me-2"></i> Layanan Administrasi & Kependudukan</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('surat.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Pilih Layanan Surat</label>
                    <select name="jenis_surat" id="jenis_surat" class="form-select form-select-lg" required onchange="aturFormulir()">
                        <option value="" selected disabled>-- Silakan Pilih Jenis Layanan --</option>
                        
                        <optgroup label="Layanan Administrasi Umum">
                            <option value="Surat Keterangan Kelahiran">Surat Keterangan Kelahiran</option>
                            <option value="Surat Keterangan Kematian">Surat Keterangan Kematian</option>
                            <option value="Surat Domisili Tempat Tinggal">Surat Domisili Tempat Tinggal</option>
                            <option value="Surat Pernyataan Ahli Waris">Surat Pernyataan Ahli Waris</option>
                            <option value="Surat Keterangan Usaha">Surat Keterangan Domisili Usaha</option>
                            <option value="Surat Pengantar Nikah">Surat Pengantar Nikah</option>
                        </optgroup>
                        
                        <optgroup label="Layanan Kependudukan">
                            <option value="Permohonan KTP">Permohonan KTP Elektronik</option>
                            <option value="Permohonan KK">Permohonan Kartu Keluarga</option>
                            <option value="Permohonan Pindah">Permohonan Pindah Tempat</option>
                        </optgroup>
                    </select>
                </div>

                <div id="info_syarat" class="alert alert-info d-none">
                    <h6 class="fw-bold"><i class="fas fa-info-circle me-1"></i> Persyaratan Dokumen:</h6>
                    <ul id="list_syarat" class="mb-0 small">
                        </ul>
                    <hr>
                    <small class="fst-italic">*Harap bawa dokumen asli dan fotocopy tersebut ke kantor desa setelah mengajukan online.</small>
                </div>

                <div id="form_kelahiran" class="detail-form d-none p-3 mb-4 bg-light rounded border">
                    <h6 class="fw-bold text-primary">Data Kelahiran</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label">Nama Bayi</label><input type="text" name="nama_bayi" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Tanggal Lahir</label><input type="date" name="tgl_lahir_bayi" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Tempat Lahir</label><input type="text" name="tempat_lahir_bayi" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Nama Ibu Kandung</label><input type="text" name="nama_ibu" class="form-control"></div>
                    </div>
                </div>

                <div id="form_kematian" class="detail-form d-none p-3 mb-4 bg-light rounded border">
                    <h6 class="fw-bold text-danger">Data Kematian</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label">Nama Almarhum/ah</label><input type="text" name="nama_alm" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label class="form-label">NIK Almarhum/ah</label><input type="number" name="nik_alm" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Tanggal Meninggal</label><input type="date" name="tgl_meninggal" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Sebab Meninggal</label><input type="text" name="sebab" class="form-control" placeholder="Sakit/Kecelakaan/dll"></div>
                    </div>
                </div>

                <div id="form_nikah" class="detail-form d-none p-3 mb-4 bg-light rounded border">
                    <h6 class="fw-bold text-primary">Data Calon Pasangan</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label">Nama Calon</label><input type="text" name="nama_calon_pasangan" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label class="form-label">NIK Calon</label><input type="number" name="nik_calon_pasangan" class="form-control"></div>
                        </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Catatan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Saya akan datang ke kantor desa hari Senin..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary px-4">Kirim Pengajuan</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Data Syarat sesuai Gambar yang kamu kirim
    const dataSyarat = {
        "Surat Keterangan Kelahiran": [
            "Pengantar RT/RW", "KTP-EL Suami & Istri", "Kartu Keluarga", "Buku Nikah / Akta Nikah", "Surat Kelahiran Bidan/RS"
        ],
        "Surat Keterangan Kematian": [
            "Pengantar RT/RW", "Surat Kematian RS (jika di RS)", "KTP Pelapor & Saksi", "KK Jenazah & Pelapor"
        ],
        "Surat Pengantar Nikah": [
            "Pengantar RT/RW", "Fotocopy KTP, KK, Ijazah, Akta Lahir", "Foto 2x3 (8 lembar) latar biru", "Surat Cerai (jika status Janda/Duda)"
        ],
        "Surat Domisili Tempat Tinggal": [
            "Pengantar RT/RW", "KTP-EL", "KK", "Surat Pernyataan Bermaterai"
        ],
        "Surat Keterangan Usaha": [
            "Pengantar RT/RW", "KTP-EL", "KK", "Bukti Lunas PBB", "Foto Tempat Usaha"
        ]
    };

    function aturFormulir() {
        var jenis = document.getElementById("jenis_surat").value;
        
        // 1. ATUR SYARAT
        var boxSyarat = document.getElementById("info_syarat");
        var listSyarat = document.getElementById("list_syarat");
        
        // Reset list
        listSyarat.innerHTML = "";
        
        if (dataSyarat[jenis]) {
            boxSyarat.classList.remove("d-none"); // Munculkan kotak
            dataSyarat[jenis].forEach(function(item) {
                var li = document.createElement("li");
                li.textContent = item;
                listSyarat.appendChild(li);
            });
        } else {
            boxSyarat.classList.add("d-none"); // Sembunyikan jika tidak ada data
        }

        // 2. ATUR FORM INPUT
        // Sembunyikan semua dulu
        document.querySelectorAll('.detail-form').forEach(el => el.classList.add('d-none'));

        // Munculkan yang dipilih
        if (jenis === "Surat Keterangan Kelahiran") {
            document.getElementById("form_kelahiran").classList.remove("d-none");
        } else if (jenis === "Surat Keterangan Kematian") {
            document.getElementById("form_kematian").classList.remove("d-none");
        } else if (jenis === "Surat Pengantar Nikah") {
            document.getElementById("form_nikah").classList.remove("d-none");
        }
    }
</script>
@endsection