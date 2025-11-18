@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm bg-primary text-white" style="background: linear-gradient(45deg, #0d6efd, #0a58ca);">
                <div class="card-body p-4">
                    <h2 class="fw-bold">Halo, {{ Auth::user()->name }}! 👋</h2>
                    <p class="mb-0 lead">Selamat datang di Portal Layanan Mandiri Desa Sidokerto.</p>
                    <p class="small text-white-50 mt-1">Anda login sebagai Warga Desa.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <span class="fa-stack fa-3x text-primary">
                            <i class="fas fa-circle fa-stack-2x opacity-25"></i>
                            <i class="fas fa-envelope-open-text fa-stack-1x"></i>
                        </span>
                    </div>
                    <h5 class="card-title fw-bold">Pengajuan Surat</h5>
                    <p class="card-text text-muted small">Butuh surat pengantar atau keterangan? Ajukan secara online di sini tanpa antri.</p>
                    <a href="{{ route('surat.create') }}" class="btn btn-primary w-100 rounded-pill">Buat Pengajuan</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <span class="fa-stack fa-3x text-info">
                            <i class="fas fa-circle fa-stack-2x opacity-25"></i>
                            <i class="fas fa-history fa-stack-1x"></i>
                        </span>
                    </div>
                    <h5 class="card-title fw-bold">Riwayat & Status</h5>
                    <p class="card-text text-muted small">Pantau progres surat yang sedang diproses atau lihat riwayat pengajuan sebelumnya.</p>
                    <a href="{{ route('surat.index') }}"  class="btn btn-outline-info w-100 rounded-pill">Cek Status</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm hover-card">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <span class="fa-stack fa-3x text-success">
                            <i class="fas fa-circle fa-stack-2x opacity-25"></i>
                            <i class="fas fa-id-card fa-stack-1x"></i>
                        </span>
                    </div>
                    <h5 class="card-title fw-bold">Data Diri</h5>
                    <p class="card-text text-muted small">Pastikan data kependudukan Anda (Biodata) sudah benar dan terbaru.</p>
                    <a href="#" class="btn btn-outline-success w-100 rounded-pill">Lihat Profil</a>
                </div>
            </div>
        </div>

    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="fas fa-info-circle fa-2x me-3"></i>
                <div>
                    <strong>Informasi Penting:</strong>
                    <br>
                    Pelayanan kantor desa buka hari Senin - Jumat, pukul 08.00 - 15.00 WIB. Pengajuan surat di luar jam kerja akan diproses pada hari kerja berikutnya.
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Sedikit CSS tambahan biar card-nya bisa 'mental' pas di-hover --}}
<style>
    .hover-card { transition: transform 0.3s ease; }
    .hover-card:hover { transform: translateY(-5px); }
</style>
@endsection