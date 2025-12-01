@extends('layouts.admin')

@section('content')
<div class="container">
    
    <!-- Welcome Banner -->
    <div class="card border-0 shadow-sm mb-4 bg-primary text-white overflow-hidden rounded-3">
        <div class="card-body p-4 position-relative">
            <div class="row align-items-center">
                <div class="col-md-8 position-relative z-index-1">
                    <h3 class="fw-bold mb-1">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="mb-0 opacity-75">Selamat datang di Portal Layanan Mandiri Desa Sidokerto. Semua urusan administrasi kini lebih mudah.</p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <i class="fas fa-id-card fa-5x opacity-25" style="transform: rotate(15deg);"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Pintas (Shortcut) -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <a href="{{ route('surat.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-shadow transition">
                    <div class="card-body text-center p-4">
                        <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-envelope-open-text fa-2x text-primary"></i>
                        </div>
                        <h6 class="fw-bold text-dark">Ajukan Surat</h6>
                        <p class="small text-muted mb-0">Buat surat pengantar, keterangan usaha, dll.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('pengaduan.create') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-shadow transition">
                    <div class="card-body text-center p-4">
                        <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-bullhorn fa-2x text-danger"></i>
                        </div>
                        <h6 class="fw-bold text-dark">Lapor / Pengaduan</h6>
                        <p class="small text-muted mb-0">Laporkan masalah lingkungan atau fasilitas.</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('warga.profil') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-shadow transition">
                    <div class="card-body text-center p-4">
                        <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fas fa-user-cog fa-2x text-success"></i>
                        </div>
                        <h6 class="fw-bold text-dark">Profil Saya</h6>
                        <p class="small text-muted mb-0">Cek dan perbarui biodata kependudukan.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Status Terakhir -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold text-primary m-0"><i class="fas fa-clock me-2"></i> Aktivitas Terakhir Anda</h6>
                </div>
                <div class="card-body">
                    @if(isset($suratTerakhir) && $suratTerakhir)
                        <div class="d-flex align-items-center p-3 border rounded mb-3">
                            <div class="flex-shrink-0 me-3 text-center" style="width: 50px;">
                                <i class="fas fa-file-alt fa-2x text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-0 text-dark">{{ strtoupper(str_replace('_', ' ', $suratTerakhir->jenis_surat)) }}</h6>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($suratTerakhir->tanggal_ajuan)->diffForHumans() }}</small>
                            </div>
                            <div>
                                @if($suratTerakhir->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Proses</span>
                                @elseif($suratTerakhir->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <p class="text-muted text-center py-3">Belum ada pengajuan surat.</p>
                    @endif

                    @if(isset($aduanTerakhir) && $aduanTerakhir)
                        <div class="d-flex align-items-center p-3 border rounded">
                            <div class="flex-shrink-0 me-3 text-center" style="width: 50px;">
                                <i class="fas fa-comment-dots fa-2x text-danger"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-0 text-dark">{{ Str::limit($aduanTerakhir->judul, 25) }}</h6>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($aduanTerakhir->tanggal_lapor)->diffForHumans() }}</small>
                            </div>
                            <div>
                                @if($aduanTerakhir->status == 'masuk')
                                    <span class="badge bg-warning text-dark">Terkirim</span>
                                @else
                                    <span class="badge bg-success">Direspon</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 rounded-3 h-100 bg-light">
                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center p-5">
                    <i class="fas fa-headset fa-3x text-muted mb-3"></i>
                    <h6 class="fw-bold text-dark">Butuh Bantuan?</h6>
                    <p class="small text-muted mb-3">Hubungi perangkat desa jika anda mengalami kesulitan dalam menggunakan aplikasi ini.</p>
                    <button class="btn btn-outline-secondary btn-sm rounded-pill px-4">
                        <i class="fab fa-whatsapp me-1"></i> Chat Admin Desa
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .hover-shadow:hover { transform: translateY(-3px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; transition: 0.3s; }
    .transition { transition: 0.3s; }
</style>
@endsection