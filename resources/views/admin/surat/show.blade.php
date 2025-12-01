@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <a href="{{ route('admin.surat.index') }}" class="btn btn-secondary mb-3 btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Pengajuan: {{ strtoupper(str_replace('_', ' ', $surat->jenis_surat)) }}</h5>
                    <span class="badge bg-light text-dark">{{ $surat->status }}</span>
                </div>
                <div class="card-body">
                    
                    <h6 class="fw-bold text-gray-800">A. Data Pemohon</h6>
                    <table class="table table-borderless table-sm mb-4">
                        <tr><td width="150">Nama Lengkap</td><td>: {{ $surat->user->name }}</td></tr>
                        <tr><td>NIK</td><td>: {{ $surat->user->biodata->nik ?? '-' }}</td></tr>
                        <tr><td>Tanggal Ajuan</td><td>: {{ $surat->tanggal_ajuan }}</td></tr>
                    </table>

                    <hr>

                    <h6 class="fw-bold text-gray-800">B. Detail Informasi Surat</h6>
                    <div class="bg-light p-3 rounded border mb-3">
                        
                        @if($surat->foto_lampiran)
                            <div class="mb-3 text-center">
                                <p class="fw-bold small text-muted mb-1">Bukti Lampiran Warga:</p>
                                <img src="{{ asset('storage/' . $surat->foto_lampiran) }}" 
                                     class="img-fluid rounded shadow-sm border" 
                                     style="max-height: 300px;">
                                <br>
                                <a href="{{ asset('storage/' . $surat->foto_lampiran) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                    <i class="fas fa-expand me-1"></i> Lihat Ukuran Penuh
                                </a>
                            </div>
                            <hr>
                        @endif

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
                        @else
                            <p class="text-danger">Data detail tidak ditemukan.</p>
                        @endif
                        
                        @if($surat->keterangan)
                            <hr>
                            <p class="mb-0"><strong>Catatan Warga:</strong> <br> <em>"{{ $surat->keterangan }}"</em></p>
                        @endif
                    </div>

                    @if($surat->status == 'menunggu')
                    <hr class="my-4">
                    <h6 class="fw-bold">Tindakan Admin:</h6>
                    
                    <form action="{{ route('admin.surat.update', $surat->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label>Catatan Admin (Opsional)</label>
                            <textarea name="pesan_admin" class="form-control" placeholder="Contoh: Silakan ambil surat hari Senin..."></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" name="status" value="selesai" class="btn btn-success w-50">
                                <i class="fas fa-check-circle"></i> SETUJUI (ACC)
                            </button>
                            <button type="submit" name="status" value="ditolak" class="btn btn-danger w-50">
                                <i class="fas fa-times-circle"></i> TOLAK
                            </button>
                        </div>
                    </form>
                    @endif

                    @if($surat->status != 'menunggu')
                        <div class="alert alert-{{ $surat->status == 'selesai' ? 'success' : 'danger' }} mt-4 text-center">
                            <strong>Surat ini telah {{ strtoupper($surat->status) }}</strong>
                            @if($surat->nomor_surat)
                                <br>Nomor Surat: <strong>{{ $surat->nomor_surat }}</strong>
                            @endif
                        </div>

                        @if($surat->status == 'selesai')
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.surat.cetak', $surat->id) }}" class="btn btn-warning btn-lg px-5 fw-bold" target="_blank">
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