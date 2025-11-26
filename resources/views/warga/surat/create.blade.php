@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-envelope-open-text me-2"></i> Layanan Administrasi & Kependudukan</h5>
        </div>
        <div class="card-body p-4">
            
            <!-- [BARU] CEK BIODATA SEBELUM ISI FORM -->
            <!-- Ini akan memberi tahu warga data siapa yang dipakai -->
            @if(isset($biodata) && !$biodata->nik)
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Perhatian!</strong> Biodata Anda belum lengkap. 
                    <a href="{{ route('warga.profil') }}" class="alert-link text-decoration-underline">Klik di sini untuk melengkapi Profil</a> agar data surat otomatis terisi dengan benar.
                </div>
            @else
                <div class="alert alert-success py-2 mb-4 border-0 bg-success-subtle text-success-emphasis">
                    <small>
                        <i class="fas fa-user-check me-1"></i> 
                        Mengajukan sebagai: <strong>{{ $user->name }}</strong> 
                        @if(isset($biodata) && $biodata->nik) (NIK: {{ $biodata->nik }}) @endif
                    </small>
                </div>
            @endif

            <form action="{{ route('surat.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Pilih Layanan Surat</label>
                    <select name="jenis_surat" id="jenis_surat" class="form-select form-select-lg" required onchange="aturFormulir()">
                        <option value="" selected disabled>-- Silakan Pilih Jenis Layanan --</option>
                        
                        <optgroup label="Layanan Umum">
                            <option value="surat_usaha">Surat Keterangan Usaha</option>
                            <option value="surat_nikah">Surat Pengantar Nikah</option>
                            <option value="surat_tanah">Surat Keterangan Tanah</option>
                        </optgroup>
                        
                        <optgroup label="Layanan Kependudukan">
                            <option value="surat_kelahiran">Surat Keterangan Kelahiran</option>
                            <option value="surat_kematian">Surat Keterangan Kematian</option>
                        </optgroup>
                    </select>
                </div>

                <!-- Info Syarat -->
                <div id="info_syarat" class="alert alert-info d-none">
                    <h6 class="fw-bold"><i class="fas fa-info-circle me-1"></i> Persyaratan Dokumen:</h6>
                    <ul id="list_syarat" class="mb-0 small"></ul>
                    <hr>
                    <small class="fst-italic">*Harap bawa dokumen asli dan fotocopy tersebut ke kantor desa saat pengambilan surat.</small>
                </div>

                <!-- 1. FORM SURAT USAHA -->
                <div id="form_surat_usaha" class="detail-form d-none p-3 mb-4 bg-light rounded border">
                    <h6 class="fw-bold text-success">Detail Usaha</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Usaha</label>
                            <input type="text" name="nama_usaha" class="form-control" placeholder="Contoh: Warung Makan Sejahtera">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Usaha</label>
                            <input type="text" name="jenis_usaha" class="form-control" placeholder="Contoh: Kuliner / Perdagangan">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Alamat Usaha</label>
                            <textarea name="alamat_usaha" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. FORM SURAT NIKAH -->
                <div id="form_surat_nikah" class="detail-form d-none p-3 mb-4 bg-light rounded border">
                    <h6 class="fw-bold text-primary">Data Calon Pasangan</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Calon Pasangan</label>
                            <input type="text" name="nama_calon_pasangan" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIK Calon Pasangan</label>
                            <input type="number" name="nik_calon_pasangan" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir_calon" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir_calon" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan_calon" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status Perkawinan</label>
                            <select name="status_perkawinan_calon" class="form-select">
                                <option value="Jejaka">Jejaka</option>
                                <option value="Perawan">Perawan</option>
                                <option value="Duda">Duda</option>
                                <option value="Janda">Janda</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat_calon" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>

                <!-- 3. FORM SURAT TANAH -->
                <div id="form_surat_tanah" class="detail-form d-none p-3 mb-4 bg-light rounded border">
                    <h6 class="fw-bold text-warning">Detail Tanah</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Lokasi Tanah</label>
                            <input type="text" name="lokasi_tanah" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Luas Tanah (m2)</label>
                            <input type="number" name="luas_tanah_m2" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor Kohir (Jika ada)</label>
                            <input type="text" name="nomor_kohir" class="form-control">
                        </div>
                        <div class="col-12"><label class="form-label fw-bold">Batas-batas Tanah:</label></div>
                        <div class="col-md-3 mb-2"><input type="text" name="batas_utara" class="form-control" placeholder="Utara"></div>
                        <div class="col-md-3 mb-2"><input type="text" name="batas_timur" class="form-control" placeholder="Timur"></div>
                        <div class="col-md-3 mb-2"><input type="text" name="batas_selatan" class="form-control" placeholder="Selatan"></div>
                        <div class="col-md-3 mb-2"><input type="text" name="batas_barat" class="form-control" placeholder="Barat"></div>
                    </div>
                </div>

                <!-- 4. FORM SURAT KELAHIRAN -->
                <div id="form_surat_kelahiran" class="detail-form d-none p-3 mb-4 bg-light rounded border">
                    <h6 class="fw-bold text-info">Data Kelahiran</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Bayi</label>
                            <input type="text" name="nama_bayi" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin_bayi" class="form-select">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir_bayi" class="form-control" value="Sidoarjo">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir_bayi" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jam Lahir</label>
                            <input type="time" name="jam_lahir" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Anak ke-</label>
                            <input type="number" name="anak_ke" class="form-control">
                        </div>
                        <div class="col-12"><hr></div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Ayah</label>
                            <input type="text" name="nama_ayah" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Ibu</label>
                            <input type="text" name="nama_ibu" class="form-control">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Hubungan Pelapor dengan Bayi</label>
                            <input type="text" name="hubungan_pelapor" class="form-control" value="Orang Tua">
                        </div>
                    </div>
                </div>

                <!-- 5. FORM SURAT KEMATIAN -->
                <div id="form_surat_kematian" class="detail-form d-none p-3 mb-4 bg-light rounded border">
                    <h6 class="fw-bold text-danger">Data Kematian</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Almarhum/ah</label>
                            <input type="text" name="nama_almarhum" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIK Almarhum</label>
                            <input type="number" name="nik_almarhum" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bin / Binti</label>
                            <input type="text" name="bin_binti" class="form-control">
                        </div>
                        <div class="col-12"><hr></div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tanggal Meninggal</label>
                            <input type="date" name="tanggal_meninggal" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jam Meninggal</label>
                            <input type="time" name="jam_meninggal" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tempat Meninggal</label>
                            <input type="text" name="tempat_meninggal" class="form-control" placeholder="Rumah / RS...">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Sebab Meninggal</label>
                            <textarea name="sebab_meninggal" class="form-control" rows="2" placeholder="Sakit tua / Kecelakaan / dll"></textarea>
                        </div>
                        <div class="col-12"><hr></div>
                        
                        <!-- [AUTO-FILL] BAGIAN INI YANG DITAMBAHKAN -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Pelapor</label>
                            <input type="text" name="nama_pelapor" class="form-control bg-light" value="{{ $user->name }}" readonly>
                            <small class="text-muted">*Otomatis diambil dari nama akun Anda</small>
                        </div>
                        <!-- [SELESAI AUTO-FILL] -->

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hubungan Pelapor</label>
                            <input type="text" name="hubungan_pelapor" class="form-control" placeholder="Anak / Istri / Suami">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Catatan Tambahan (Opsional)</label>
                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Saya butuh surat ini secepatnya..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary px-4">Kirim Pengajuan</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Data Syarat
    const dataSyarat = {
        "surat_usaha": ["Pengantar RT/RW", "KTP-EL", "KK", "Bukti Lunas PBB", "Foto Tempat Usaha"],
        "surat_nikah": ["Pengantar RT/RW", "Fotocopy KTP, KK, Ijazah, Akta Lahir", "Foto 2x3 (8 lembar) latar biru", "Surat Cerai (jika status Janda/Duda)"],
        "surat_tanah": ["Pengantar RT/RW", "KTP-EL", "KK", "Bukti Kepemilikan Tanah (Letter C/Sertifikat)", "SPPT PBB Terakhir"],
        "surat_kelahiran": ["Pengantar RT/RW", "KTP-EL Orang Tua", "KK", "Buku Nikah Orang Tua", "Surat Keterangan Bidan/RS"],
        "surat_kematian": ["Pengantar RT/RW", "KTP Pelapor & Saksi", "KK Jenazah & Pelapor", "Surat Kematian RS (jika ada)"]
    };

    function aturFormulir() {
        var jenis = document.getElementById("jenis_surat").value;
        
        // 1. ATUR SYARAT
        var boxSyarat = document.getElementById("info_syarat");
        var listSyarat = document.getElementById("list_syarat");
        
        listSyarat.innerHTML = ""; // Reset list
        
        if (dataSyarat[jenis]) {
            boxSyarat.classList.remove("d-none");
            dataSyarat[jenis].forEach(function(item) {
                var li = document.createElement("li");
                li.textContent = item;
                listSyarat.appendChild(li);
            });
        } else {
            boxSyarat.classList.add("d-none");
        }

        // 2. ATUR FORM INPUT
        // Sembunyikan semua detail-form
        document.querySelectorAll('.detail-form').forEach(el => el.classList.add('d-none'));

        // Munculkan form sesuai ID (format: form_nama_value)
        var formId = "form_" + jenis;
        var formEl = document.getElementById(formId);
        if(formEl) {
            formEl.classList.remove("d-none");
        }
    }
</script>
@endsection