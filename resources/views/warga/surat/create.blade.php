@extends('layouts.admin')

@section('content')
<div class="container pb-5">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0 text-primary">Buat Pengajuan Surat Baru</h5>
        </div>
        <div class="card-body">
            
            <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-bold">Jenis Surat</label>
                    <select name="jenis_surat" id="jenis_surat" class="form-select" required onchange="gantiForm()">
                        <option value="" selected>-- Pilih Jenis Surat --</option>
                        <option value="surat_domisili">Surat Keterangan Domisili / Pindah</option>
                        <option value="surat_kelahiran">Surat Keterangan Kelahiran</option>
                        <option value="surat_kematian">Surat Keterangan Kematian</option>
                        <option value="surat_usaha">Surat Keterangan Usaha</option>
                        <option value="surat_nikah">Surat Pengantar Nikah</option>
                        <option value="surat_tanah">Surat Keterangan Kepemilikan Tanah</option>
                    </select>
                </div>

                <div class="mb-4 p-3 bg-light rounded border" id="area-syarat" style="display: none;">
                    <h6 class="fw-bold mb-3 text-primary"><i class="fas fa-paperclip me-1"></i> 1. Upload Dokumen Persyaratan:</h6>
                    <div id="list-syarat">
                        </div>
                    <small class="text-danger">* Wajib diisi. Format: JPG/PNG/PDF. Maks 2MB.</small>
                </div>

                <div id="area-form-detail">
                    
                    <div id="form_surat_usaha" class="form-khusus" style="display:none;">
                        <h6 class="fw-bold mb-3 text-primary"><i class="fas fa-edit me-1"></i> 2. Detail Usaha</h6>
                        <div class="mb-3">
                            <label>Nama Usaha</label>
                            <input type="text" name="nama_usaha" class="form-control" placeholder="Contoh: Warung Makan Sejahtera">
                        </div>
                        <div class="mb-3">
                            <label>Jenis Usaha</label>
                            <input type="text" name="jenis_usaha" class="form-control" placeholder="Contoh: Kuliner / Perdagangan">
                        </div>
                        <div class="mb-3">
                            <label>Alamat Usaha</label>
                            <textarea name="alamat_usaha" class="form-control" rows="2"></textarea>
                        </div>
                    </div>

                    <div id="form_surat_kematian" class="form-khusus" style="display:none;">
                        <h6 class="fw-bold mb-3 text-primary"><i class="fas fa-edit me-1"></i> 2. Detail Almarhum/Almarhumah</h6>
                        <div class="mb-3">
                            <label>Nama Almarhum/ah</label>
                            <input type="text" name="nama_almarhum" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>NIK Almarhum/ah (Jika ada)</label>
                            <input type="number" name="nik_almarhum" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Meninggal</label>
                            <input type="date" name="tanggal_meninggal" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Tempat Meninggal</label>
                            <input type="text" name="tempat_meninggal" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Penyebab Meninggal</label>
                            <input type="text" name="sebab_meninggal" class="form-control" placeholder="Sakit / Kecelakaan / Tua">
                        </div>
                    </div>

                    <div id="form_surat_kelahiran" class="form-khusus" style="display:none;">
                        <h6 class="fw-bold mb-3 text-primary"><i class="fas fa-edit me-1"></i> 2. Detail Bayi</h6>
                        <div class="mb-3">
                            <label>Nama Bayi</label>
                            <input type="text" name="nama_bayi" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir_bayi" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Nama Ayah</label>
                            <input type="text" name="nama_ayah" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Nama Ibu</label>
                            <input type="text" name="nama_ibu" class="form-control">
                        </div>
                    </div>

                    <div id="form_surat_domisili" class="form-khusus" style="display:none;">
                        <h6 class="fw-bold mb-3 text-primary"><i class="fas fa-edit me-1"></i> 2. Detail Kepindahan</h6>
                        <div class="mb-3">
                            <label>Alamat Asal</label>
                            <textarea name="alamat_asal" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Alamat Tujuan</label>
                            <textarea name="alamat_tujuan" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Alasan Pindah</label>
                            <input type="text" name="alasan_pindah" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Jumlah Pengikut</label>
                            <input type="number" name="jumlah_pengikut" class="form-control" value="0">
                        </div>
                    </div>

                    <div id="form_surat_nikah" class="form-khusus" style="display:none;">
                        <h6 class="fw-bold mb-3 text-primary"><i class="fas fa-heart me-1"></i> 2. Detail Calon Pasangan</h6>
                        <div class="mb-3">
                            <label>Nama Calon Pasangan</label>
                            <input type="text" name="nama_calon_pasangan" class="form-control" placeholder="Nama Lengkap Bin/Binti">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>NIK Calon Pasangan</label>
                                <input type="number" name="nik_calon_pasangan" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Pekerjaan Calon</label>
                                <input type="text" name="pekerjaan_calon" class="form-control" placeholder="Contoh: Wiraswasta">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tempat Lahir</label>
                                <input type="text" name="tempat_lahir_calon" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir_calon" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Status Perkawinan</label>
                            <select name="status_perkawinan_calon" class="form-select">
                                <option value="Jejaka">Jejaka</option>
                                <option value="Perawan">Perawan</option>
                                <option value="Duda">Duda</option>
                                <option value="Janda">Janda</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Alamat Lengkap Calon</label>
                            <textarea name="alamat_calon" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Tempat Acara Pernikahan (Opsional)</label>
                            <input type="text" name="tempat_acara_calon" class="form-control" placeholder="Contoh: KUA Kecamatan Buduran">
                        </div>
                    </div>

                    <div id="form_surat_tanah" class="form-khusus" style="display:none;">
                        <h6 class="fw-bold mb-3 text-primary"><i class="fas fa-map-marked-alt me-1"></i> 2. Detail Tanah</h6>
                        <div class="mb-3">
                            <label>Lokasi Tanah / Blok / Persil</label>
                            <input type="text" name="lokasi_tanah" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Luas Tanah (m2)</label>
                                <input type="number" name="luas_tanah_m2" class="form-control" placeholder="Contoh: 100">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Nomor Kohir / Letter C</label>
                                <input type="text" name="nomor_kohir" class="form-control">
                            </div>
                        </div>
                        <label class="form-label fw-bold small">Batas-Batas Tanah:</label>
                        <div class="row">
                            <div class="col-md-3 mb-2"><input type="text" name="batas_utara" class="form-control form-control-sm" placeholder="Utara"></div>
                            <div class="col-md-3 mb-2"><input type="text" name="batas_timur" class="form-control form-control-sm" placeholder="Timur"></div>
                            <div class="col-md-3 mb-2"><input type="text" name="batas_selatan" class="form-control form-control-sm" placeholder="Selatan"></div>
                            <div class="col-md-3 mb-2"><input type="text" name="batas_barat" class="form-control form-control-sm" placeholder="Barat"></div>
                        </div>
                        <div class="mb-3 mt-2">
                            <label>Riwayat Kepemilikan (Asal Usul Tanah)</label>
                            <textarea name="riwayat_kepemilikan" class="form-control" rows="2" placeholder="Contoh: Warisan dari Bapak X / Jual Beli tahun 1990"></textarea>
                        </div>
                    </div>

                </div>

                <hr>

                <div class="mb-3">
                    <label class="form-label">Keterangan Tambahan (Opsional)</label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Mohon diproses cepat untuk pendaftaran sekolah"></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                    <i class="fas fa-paper-plane me-1"></i> Kirim Pengajuan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function gantiForm() {
        const jenis = document.getElementById('jenis_surat').value;
        const areaSyarat = document.getElementById('area-syarat');
        const listSyarat = document.getElementById('list-syarat');

        // 1. Reset Semua Form Khusus (Sembunyikan dulu semua)
        document.querySelectorAll('.form-khusus').forEach(el => el.style.display = 'none');
        
        // 2. Reset List Syarat
        listSyarat.innerHTML = '';
        areaSyarat.style.display = 'none';

        if (jenis === '') return;

        // 3. Tampilkan Form Khusus Sesuai Pilihan
        const targetForm = document.getElementById('form_' + jenis);
        if (targetForm) {
            targetForm.style.display = 'block';
        }

        // 4. Tentukan Syarat Dokumen (Dinamis)
        let syarat = [];
        if (jenis === 'surat_domisili') {
            syarat = ['Scan KTP Asli', 'Scan Kartu Keluarga (KK)', 'Surat Pengantar RT/RW'];
        } else if (jenis === 'surat_kelahiran') {
            syarat = ['KTP Ayah & Ibu', 'Kartu Keluarga (KK)', 'Surat Keterangan RS/Bidan'];
        } else if (jenis === 'surat_kematian') {
            syarat = ['KTP Almarhum', 'KK Almarhum', 'Surat Keterangan RS (Jika ada)'];
        } else if (jenis === 'surat_usaha') {
            syarat = ['KTP Pemilik', 'Foto Tempat Usaha'];
        } else if (jenis === 'surat_nikah') {
            syarat = ['KTP Calon Suami & Istri', 'KK', 'Surat Pernyataan Belum Menikah'];
        } else if (jenis === 'surat_tanah') {
            syarat = ['KTP Pemilik', 'Bukti PBB', 'Fotokopi Letter C'];
        }

        // 5. Render Input File Syarat
        if (syarat.length > 0) {
            areaSyarat.style.display = 'block';
            syarat.forEach((item) => {
                const html = `
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">${item}</label>
                        <input type="file" name="lampiran[${item}]" class="form-control form-control-sm" required>
                    </div>
                `;
                listSyarat.innerHTML += html;
            });
        }
    }
</script>
@endsection