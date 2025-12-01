@extends('layouts.admin')

@section('content')
<div class="container">
    
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Layanan Surat Menyurat</h2>
        <p class="text-muted">Ajukan permohonan surat administrasi desa secara mandiri, cepat, dan mudah.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-9">

            <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card border-0 shadow-sm mb-4 rounded-3">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold text-primary m-0"><i class="fas fa-user-check me-2"></i> Data Pemohon (Otomatis)</h6>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold">NAMA LENGKAP</label>
                                <p class="mb-0 fw-bold text-dark">{{ $biodata->nama_lengkap ?? Auth::user()->name }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold">NIK</label>
                                <p class="mb-0 fw-bold text-dark">{{ $biodata->nik ?? '-' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="small text-muted fw-bold">ALAMAT</label>
                                <p class="mb-0 text-dark">{{ $biodata->alamat ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-lg mb-4 rounded-3">
                    <div class="card-body p-4">
                        <label class="form-label fw-bold h5">Jenis Surat Apa yang Anda Butuhkan?</label>
                        <select name="jenis_surat" id="jenis_surat" class="form-select form-select-lg border-primary bg-light mb-3" required onchange="aturFormulir()">
                            <option value="" selected disabled>-- Klik untuk memilih layanan --</option>
                            <optgroup label="Layanan Umum">
                                <option value="surat_usaha">📝 Surat Keterangan Usaha (SKU)</option>
                                <option value="surat_nikah">💍 Surat Pengantar Nikah (N1-N4)</option>
                                <option value="surat_tanah">🏞️ Surat Keterangan Tanah</option>
                            </optgroup>
                            <optgroup label="Layanan Kependudukan">
                                <option value="surat_kelahiran">👶 Surat Keterangan Kelahiran</option>
                                <option value="surat_kematian">⚰️ Surat Keterangan Kematian</option>
                            </optgroup>
                        </select>

                        <div id="info_syarat" class="alert alert-info border-0 d-none shadow-sm">
                            <h6 class="fw-bold"><i class="fas fa-info-circle me-2"></i> Persyaratan Dokumen:</h6>
                            <ul id="list_syarat" class="mb-0 small ps-3"></ul>
                            <hr>
                            <small class="fst-italic">*Harap bawa dokumen asli & fotocopy ke kantor desa saat pengambilan surat.</small>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow mb-4 rounded-3">
                    <div class="card-body p-4">
                        
                        <div id="form_placeholder" class="text-center py-5 text-muted">
                            <i class="fas fa-file-alt fa-3x mb-3 opacity-25"></i>
                            <p>Silakan pilih jenis surat di atas untuk mengisi formulir.</p>
                        </div>

                        <div id="form_surat_usaha" class="detail-form d-none">
                            <h5 class="fw-bold text-success mb-4 border-bottom pb-2">Detail Usaha</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Usaha</label>
                                    <input type="text" name="nama_usaha" class="form-control" placeholder="Warung / Toko ...">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Usaha</label>
                                    <input type="text" name="jenis_usaha" class="form-control" placeholder="Kuliner / Jasa ...">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Alamat Lokasi Usaha</label>
                                    <textarea name="alamat_usaha" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <div id="form_surat_nikah" class="detail-form d-none">
                            <h5 class="fw-bold text-pink mb-4 border-bottom pb-2" style="color: #e83e8c">Data Calon Pasangan</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap Calon</label>
                                    <input type="text" name="nama_calon_pasangan" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK Calon</label>
                                    <input type="number" name="nik_calon_pasangan" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir_calon" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir_calon" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Status Perkawinan</label>
                                    <select name="status_perkawinan_calon" class="form-select">
                                        <option>Jejaka</option><option>Perawan</option><option>Duda</option><option>Janda</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Alamat Calon</label>
                                    <textarea name="alamat_calon" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                        </div>

                        <div id="form_surat_tanah" class="detail-form d-none">
                            <h5 class="fw-bold text-warning mb-4 border-bottom pb-2">Detail Tanah</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Lokasi Tanah</label>
                                    <input type="text" name="lokasi_tanah" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Luas (m2)</label>
                                    <input type="number" name="luas_tanah_m2" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Nomor Kohir/Letter C</label>
                                    <input type="text" name="nomor_kohir" class="form-control">
                                </div>
                                <div class="col-12"><label class="fw-bold">Batas-batas:</label></div>
                                <div class="col-md-3"><input type="text" name="batas_utara" class="form-control" placeholder="Utara"></div>
                                <div class="col-md-3"><input type="text" name="batas_timur" class="form-control" placeholder="Timur"></div>
                                <div class="col-md-3"><input type="text" name="batas_selatan" class="form-control" placeholder="Selatan"></div>
                                <div class="col-md-3"><input type="text" name="batas_barat" class="form-control" placeholder="Barat"></div>
                            </div>
                        </div>

                        <div id="form_surat_kelahiran" class="detail-form d-none">
                            <h5 class="fw-bold text-info mb-4 border-bottom pb-2">Data Bayi & Orang Tua</h5>
                            <div class="row g-3">
                                <div class="col-md-6"><label class="form-label">Nama Bayi</label><input type="text" name="nama_bayi" class="form-control"></div>
                                <div class="col-md-3"><label class="form-label">Jenis Kelamin</label><select name="jenis_kelamin_bayi" class="form-select"><option>Laki-laki</option><option>Perempuan</option></select></div>
                                <div class="col-md-3"><label class="form-label">Anak ke-</label><input type="number" name="anak_ke" class="form-control"></div>
                                <div class="col-md-4"><label class="form-label">Tempat Lahir</label><input type="text" name="tempat_lahir_bayi" class="form-control"></div>
                                <div class="col-md-4"><label class="form-label">Tanggal Lahir</label><input type="date" name="tanggal_lahir_bayi" class="form-control"></div>
                                <div class="col-md-4"><label class="form-label">Jam Lahir</label><input type="time" name="jam_lahir" class="form-control"></div>
                                <div class="col-md-6"><label class="form-label">Nama Ayah</label><input type="text" name="nama_ayah" class="form-control"></div>
                                <div class="col-md-6"><label class="form-label">Nama Ibu</label><input type="text" name="nama_ibu" class="form-control"></div>
                            </div>
                        </div>

                        <div id="form_surat_kematian" class="detail-form d-none">
                            <h5 class="fw-bold text-dark mb-4 border-bottom pb-2">Data Kematian</h5>
                            <div class="row g-3">
                                <div class="col-md-6"><label class="form-label">Nama Almarhum/ah</label><input type="text" name="nama_almarhum" class="form-control"></div>
                                <div class="col-md-6"><label class="form-label">NIK Almarhum</label><input type="number" name="nik_almarhum" class="form-control"></div>
                                <div class="col-md-4"><label class="form-label">Tanggal Meninggal</label><input type="date" name="tanggal_meninggal" class="form-control"></div>
                                <div class="col-md-4"><label class="form-label">Jam</label><input type="time" name="jam_meninggal" class="form-control"></div>
                                <div class="col-md-4"><label class="form-label">Tempat Meninggal</label><input type="text" name="tempat_meninggal" class="form-control"></div>
                                <div class="col-12"><label class="form-label">Sebab Meninggal</label><textarea name="sebab_meninggal" class="form-control" rows="2"></textarea></div>
                                <div class="col-md-6"><label class="form-label">Nama Pelapor</label><input type="text" name="nama_pelapor" class="form-control" value="{{ $biodata->nama_lengkap ?? Auth::user()->name }}" readonly></div>
                                <div class="col-md-6"><label class="form-label">Hubungan Pelapor</label><input type="text" name="hubungan_pelapor" class="form-control" placeholder="Istri / Anak / Ketua RT"></div>
                            </div>
                        </div>

                        <div class="alert alert-warning border-0 shadow-sm mt-4">
                            <h6 class="fw-bold text-dark"><i class="fas fa-camera me-2"></i> Bukti Lampiran (Wajib)</h6>
                            <p class="small mb-2">Silakan upload foto KTP / KK / Surat Pengantar RT/RW sebagai syarat.</p>
                            
                            <input type="file" name="foto_lampiran" class="form-control" accept="image/*" required>
                            <small class="text-muted">*Format: JPG/PNG, Maks: 2MB</small>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <label class="form-label fw-bold">Catatan Tambahan (Opsional)</label>
                            <textarea name="keterangan" class="form-control bg-light" rows="2" placeholder="Contoh: Saya butuh surat ini secepatnya..."></textarea>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">
                                <i class="fas fa-paper-plane me-2"></i> KIRIM PENGAJUAN SURAT
                            </button>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    // Data Syarat
    const dataSyarat = {
        "surat_usaha": ["KTP & KK Asli", "Bukti Lunas PBB Tahun Terakhir", "Foto Tempat Usaha"],
        "surat_nikah": ["KTP & KK Calon Suami Istri", "Ijazah Terakhir", "Akta Kelahiran", "Foto 2x3 & 3x4 (Background Biru)"],
        "surat_tanah": ["Fotocopy KTP & KK", "Letter C / Sertifikat Asli", "Bukti Pembayaran PBB"],
        "surat_kelahiran": ["KTP Ayah & Ibu", "KK", "Buku Nikah / Akta Nikah", "Surat Keterangan Lahir dari Bidan/RS"],
        "surat_kematian": ["KTP Almarhum", "KK Asli", "KTP Pelapor"]
    };

    function aturFormulir() {
        var jenis = document.getElementById("jenis_surat").value;
        var placeholder = document.getElementById("form_placeholder");
        
        // 1. ATUR SYARAT
        var boxSyarat = document.getElementById("info_syarat");
        var listSyarat = document.getElementById("list_syarat");
        listSyarat.innerHTML = "";
        
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

        // 2. ATUR FORM
        // Sembunyikan semua, munculkan placeholder
        document.querySelectorAll('.detail-form').forEach(el => el.classList.add('d-none'));
        placeholder.classList.remove('d-none');

        // Jika ada pilihan valid
        var formId = "form_" + jenis;
        var formEl = document.getElementById(formId);
        if(formEl) {
            placeholder.classList.add('d-none'); // Sembunyikan placeholder
            formEl.classList.remove("d-none");   // Munculkan form terpilih
        }
    }
</script>
@endsection