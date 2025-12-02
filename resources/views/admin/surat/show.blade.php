@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <a href="{{ route('admin.surat.index') }}" class="btn btn-secondary mb-3 btn-sm shadow-sm rounded-pill px-3">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>

            <!-- KARTU DETAIL SURAT -->
            <div class="card shadow mb-4 border-0 rounded-3">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold">Detail: {{ strtoupper(str_replace('_', ' ', $surat->jenis_surat)) }}</h5>
                    <span class="badge bg-light text-dark border">{{ ucfirst($surat->status) }}</span>
                </div>
                <div class="card-body p-4">
                    
                    <!-- A. Data Pemohon -->
                    <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="fas fa-user me-2"></i> Data Pemohon</h6>
                    <table class="table table-borderless table-sm mb-4">
                        <tr><td width="35%" class="text-muted">Nama Lengkap</td><td class="fw-bold">: {{ $surat->user->name }}</td></tr>
                        <tr><td class="text-muted">NIK</td><td class="fw-bold">: {{ $surat->user->biodata->nik ?? '-' }}</td></tr>
                        <tr><td class="text-muted">Tanggal Pengajuan</td><td class="fw-bold">: {{ \Carbon\Carbon::parse($surat->tanggal_ajuan)->format('d F Y') }}</td></tr>
                    </table>

                    <!-- B. Detail Informasi Surat -->
                    <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="fas fa-file-alt me-2"></i> Isi Surat</h6>
                    <div class="bg-light p-3 rounded border mb-3">
                        
                        <!-- TAMPILKAN FOTO BUKTI (JIKA ADA) -->
                        @if($surat->foto_lampiran)
                            <div class="mb-4 text-center">
                                <p class="fw-bold small text-muted mb-2">Bukti Lampiran Warga:</p>
                                <img src="{{ asset('storage/lampiran-surat/' . $surat->foto_lampiran) }}" 
                                     class="img-fluid rounded shadow-sm border" 
                                     style="max-height: 300px;" alt="Bukti Lampiran">
                                <br>
                                <a href="{{ asset('storage/lampiran-surat/' . $surat->foto_lampiran) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2 rounded-pill">
                                    <i class="fas fa-expand me-1"></i> Lihat Ukuran Penuh
                                </a>
                            </div>
                            <hr>
                        @endif
                        
                        <!-- LOGIKA TAMPILAN DETAIL PER JENIS SURAT -->
                        @if($surat->jenis_surat == 'surat_usaha' && $surat->detailUsaha)
                            <p><strong>Nama Usaha:</strong> {{ $surat->detailUsaha->nama_usaha }}</p>
                            <p><strong>Jenis Usaha:</strong> {{ $surat->detailUsaha->jenis_usaha }}</p>
                            <p><strong>Alamat Usaha:</strong> {{ $surat->detailUsaha->alamat_usaha }}</p>

                        @elseif($surat->jenis_surat == 'surat_nikah' && $surat->detailNikah)
                            <p><strong>Calon Pasangan:</strong> {{ $surat->detailNikah->nama_calon_pasangan }}</p>
                            <p><strong>NIK Calon:</strong> {{ $surat->detailNikah->nik_calon_pasangan }}</p>
                            <p><strong>TTL Calon:</strong> {{ $surat->detailNikah->tempat_lahir_calon }}, {{ $surat->detailNikah->tanggal_lahir_calon }}</p>
                            <p><strong>Status:</strong> {{ $surat->detailNikah->status_perkawinan_calon }}</p>

                        @elseif($surat->jenis_surat == 'surat_tanah' && $surat->detailTanah)
                            <p><strong>Lokasi Tanah:</strong> {{ $surat->detailTanah->lokasi_tanah }}</p>
                            <p><strong>Luas:</strong> {{ $surat->detailTanah->luas_tanah_m2 }} m2</p>
                            <p><strong>Batas Utara:</strong> {{ $surat->detailTanah->batas_utara }}</p>
                            <p><strong>Batas Selatan:</strong> {{ $surat->detailTanah->batas_selatan }}</p>

                        @elseif($surat->jenis_surat == 'surat_kelahiran' && $surat->detailKelahiran)
                            <p><strong>Nama Bayi:</strong> {{ $surat->detailKelahiran->nama_bayi }} ({{ $surat->detailKelahiran->jenis_kelamin_bayi }})</p>
                            <p><strong>TTL:</strong> {{ $surat->detailKelahiran->tempat_lahir_bayi }}, {{ $surat->detailKelahiran->tanggal_lahir_bayi }}</p>
                            <p><strong>Nama Ayah:</strong> {{ $surat->detailKelahiran->nama_ayah }}</p>
                            <p><strong>Nama Ibu:</strong> {{ $surat->detailKelahiran->nama_ibu }}</p>

                        @elseif($surat->jenis_surat == 'surat_kematian' && $surat->detailKematian)
                            <p><strong>Nama Almarhum:</strong> {{ $surat->detailKematian->nama_almarhum }}</p>
                            <p><strong>Tanggal Meninggal:</strong> {{ $surat->detailKematian->tanggal_meninggal }}</p>
                            <p><strong>Sebab:</strong> {{ $surat->detailKematian->sebab_meninggal }}</p>
                            <p><strong>Pelapor:</strong> {{ $surat->detailKematian->nama_pelapor }}</p>

                        <!-- [BARU] LOGIKA SURAT DOMISILI -->
                        @elseif($surat->jenis_surat == 'surat_domisili' && $surat->detailDomisili)
                            <div class="alert alert-info border-0 shadow-sm">
                                <div class="row">
                                    <div class="col-md-5">
                                        <small class="text-muted d-block">ALAMAT ASAL</small>
                                        <strong>{{ $surat->detailDomisili->alamat_asal }}</strong>
                                    </div>
                                    <div class="col-md-2 text-center align-self-center">
                                        <i class="fas fa-arrow-right fa-lg text-primary"></i>
                                    </div>
                                    <div class="col-md-5">
                                        <small class="text-muted d-block">ALAMAT TUJUAN</small>
                                        <strong>{{ $surat->detailDomisili->alamat_tujuan }}</strong>
                                    </div>
                                </div>
                            </div>
                            <p><strong>Alasan Pindah:</strong> {{ $surat->detailDomisili->alasan_pindah }}</p>
                            <p><strong>Jumlah Pengikut:</strong> {{ $surat->detailDomisili->jumlah_pengikut }} Orang</p>
                        
                        @else
                            <div class="alert alert-danger d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <div>Data detail tidak ditemukan. Pastikan warga mengisi formulir dengan lengkap.</div>
                            </div>
                        @endif
                        
                        @if($surat->keterangan)
                            <hr>
                            <p class="mb-0 small text-muted"><strong>Catatan Warga:</strong> <br> <em>"{{ $surat->keterangan }}"</em></p>
                        @endif
                    </div>

                    <!-- AREA TOMBOL AKSI -->
                    @if($surat->status == 'menunggu')
                    <div class="card bg-light border-0 p-3">
                        <h6 class="fw-bold mb-3">Tindakan Admin:</h6>
                        <form action="{{ route('admin.surat.update', $surat->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <textarea name="pesan_admin" class="form-control" rows="2" placeholder="Tulis catatan untuk warga (Opsional)..."></textarea>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" name="status" value="selesai" class="btn btn-success w-100 fw-bold shadow-sm">
                                    <i class="fas fa-check-circle me-2"></i> SETUJUI (ACC)
                                </button>
                                <button type="submit" name="status" value="ditolak" class="btn btn-danger w-100 fw-bold shadow-sm">
                                    <i class="fas fa-times-circle me-2"></i> TOLAK
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif

                    <!-- TAMPILKAN HASIL JIKA SUDAH DIPROSES -->
                    @if($surat->status != 'menunggu')
                        <div class="alert alert-{{ $surat->status == 'selesai' ? 'success' : 'danger' }} mt-4 text-center shadow-sm border-0">
                            <strong>Surat ini telah {{ strtoupper($surat->status) }}</strong>
                            @if($surat->nomor_surat)
                                <br>Nomor Surat: <strong>{{ $surat->nomor_surat }}</strong>
                            @endif
                        </div>

                        <!-- TOMBOL CETAK PDF -->
                        @if($surat->status == 'selesai')
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.surat.cetak', $surat->id) }}" class="btn btn-warning btn-lg px-5 fw-bold shadow rounded-pill" target="_blank">
                                    <i class="fas fa-print me-2"></i> CETAK SURAT (PDF)
                                </a>
                            </div>
                        @endif
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>
@endsection