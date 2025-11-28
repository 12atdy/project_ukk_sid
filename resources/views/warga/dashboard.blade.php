@extends('layouts.admin')

@section('content')
<div class="container">
    
    <!-- Banner Sapaan -->
    <div class="alert alert-primary shadow-sm border-0 mb-4">
        <h4 class="alert-heading fw-bold">
            <i class="fas fa-smile me-2"></i> Halo, {{ Auth::user()->name }}!
        </h4>
        <p class="mb-0">Selamat datang di Portal Layanan Mandiri Desa Sidokerto. Apa yang ingin Anda lakukan hari ini?</p>
    </div>

    <!-- Menu Pintas (Shortcut) -->
    <div class="row mb-4">
        <!-- Tombol Buat Surat -->
        <div class="col-md-4 mb-3">
            <a href="{{ route('surat.create') }}" class="card shadow-sm h-100 text-decoration-none border-0 bg-success text-white hover-scale">
                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center p-4">
                    <i class="fas fa-file-signature fa-3x mb-3"></i>
                    <h5 class="fw-bold">Buat Surat Baru</h5>
                    <small>Klik untuk mengajukan surat keterangan</small>
                </div>
            </a>
        </div>

        <!-- Tombol Lapor -->
        <div class="col-md-4 mb-3">
            <a href="{{ route('pengaduan.create') }}" class="card shadow-sm h-100 text-decoration-none border-0 bg-danger text-white hover-scale">
                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center p-4">
                    <i class="fas fa-bullhorn fa-3x mb-3"></i>
                    <h5 class="fw-bold">Lapor / Pengaduan</h5>
                    <small>Laporkan masalah di lingkungan Anda</small>
                </div>
            </a>
        </div>

        <!-- Tombol Profil -->
        <div class="col-md-4 mb-3">
            <a href="{{ route('warga.profil') }}" class="card shadow-sm h-100 text-decoration-none border-0 bg-info text-white hover-scale">
                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center p-4">
                    <i class="fas fa-user-cog fa-3x mb-3"></i>
                    <h5 class="fw-bold">Profil Saya</h5>
                    <small>Lengkapi biodata diri Anda</small>
                </div>
            </a>
        </div>
    </div>

    <!-- Riwayat Ringkas -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-bold text-secondary">
            <i class="fas fa-history me-2"></i> Riwayat Pengajuan Terakhir
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis Layanan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatTerakhir as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_ajuan)->format('d M Y') }}</td>
                            <td>{{ strtoupper(str_replace('_', ' ', $item->jenis_surat)) }}</td>
                            <td>
                                @if($item->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($item->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('surat.index') }}" class="btn btn-sm btn-outline-secondary">Cek</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Belum ada riwayat pengajuan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<style>
    .hover-scale:hover { transform: scale(1.02); transition: transform 0.2s; }
</style>
@endsection