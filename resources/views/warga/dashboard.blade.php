@extends('layouts.admin')

@section('content')
<div class="container">
    
    <!-- BANNER SELAMAT DATANG -->
    <div class="card border-0 shadow-sm mb-4 bg-primary text-white overflow-hidden rounded-3">
        <div class="card-body p-4 position-relative">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="fw-bold mb-1">Halo, {{ Auth::user()->name }}! 👋</h4>
                    <p class="mb-0 opacity-75">Selamat datang di Layanan Mandiri Desa. Pantau status pengajuan anda di sini.</p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <i class="fas fa-file-signature fa-4x opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- STATISTIK RINGKAS (KECIL) -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-light rounded-circle p-3 me-3 text-primary">
                        <i class="fas fa-envelope fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0">Total Surat Diajukan</h6>
                        <h3 class="fw-bold mb-0">{{ $totalSurat }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-light rounded-circle p-3 me-3 text-danger">
                        <i class="fas fa-bullhorn fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0">Total Laporan/Aduan</h6>
                        <h3 class="fw-bold mb-0">{{ $totalAduan }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- TABEL STATUS SURAT (UTAMA) -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow rounded-3 h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-primary m-0"><i class="fas fa-history me-2"></i> Status Pengajuan Surat</h6>
                    <a href="{{ route('surat.create') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                        <i class="fas fa-plus me-1"></i> Ajukan Baru
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Jenis Surat</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayatSurat as $surat)
                                <tr>
                                    <td class="ps-4">
                                        <span class="fw-bold text-dark">{{ strtoupper(str_replace('_', ' ', $surat->jenis_surat)) }}</span>
                                        @if($surat->nomor_surat)
                                            <br><small class="text-muted" style="font-size: 0.75rem;">No: {{ $surat->nomor_surat }}</small>
                                        @endif
                                    </td>
                                    <td class="small text-secondary">
                                        {{ \Carbon\Carbon::parse($surat->tanggal_ajuan)->format('d M Y') }}
                                    </td>
                                    <td>
                                        @if($surat->status == 'menunggu')
                                            <span class="badge bg-warning text-dark rounded-pill px-3">
                                                <i class="fas fa-clock me-1"></i> Diproses
                                            </span>
                                        @elseif($surat->status == 'selesai')
                                            <span class="badge bg-success rounded-pill px-3">
                                                <i class="fas fa-check-circle me-1"></i> Selesai
                                            </span>
                                        @else
                                            <span class="badge bg-danger rounded-pill px-3">
                                                <i class="fas fa-times-circle me-1"></i> Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <!-- Tombol Aksi (Tergantung Status) -->
                                        @if($surat->status == 'selesai')
                                            <button class="btn btn-sm btn-outline-success" title="Siap Diambil/Dicetak">
                                                <i class="fas fa-print"></i>
                                            </button>
                                        @elseif($surat->status == 'ditolak')
                                            <button class="btn btn-sm btn-outline-danger" title="Lihat Alasan">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-light text-muted" disabled>
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="60" class="mb-3 opacity-50">
                                        <p class="mb-0 small">Belum ada riwayat pengajuan surat.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white text-center border-0 py-3">
                    <a href="{{ route('surat.index') }}" class="text-decoration-none small fw-bold">Lihat Semua Riwayat &rarr;</a>
                </div>
            </div>
        </div>

        <!-- LIST PENGADUAN (SAMPING) -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow rounded-3 h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold text-danger m-0"><i class="fas fa-bullhorn me-2"></i> Aduan Terakhir</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($riwayatAduan as $aduan)
                        <li class="list-group-item p-3 border-bottom-0 border-top">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark small">{{ Str::limit($aduan->judul, 25) }}</h6>
                                    <small class="text-muted d-block" style="font-size: 0.7rem;">
                                        {{ \Carbon\Carbon::parse($aduan->tanggal_lapor)->diffForHumans() }}
                                    </small>
                                </div>
                                @if($aduan->status == 'masuk')
                                    <span class="badge bg-warning text-dark small" style="font-size: 0.6rem;">Menunggu</span>
                                @else
                                    <span class="badge bg-success small" style="font-size: 0.6rem;">Direspon</span>
                                @endif
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item text-center py-4 text-muted small">
                            Tidak ada laporan aktif.
                        </li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-body text-center pt-0 pb-4">
                    <a href="{{ route('pengaduan.create') }}" class="btn btn-outline-danger btn-sm w-100">Buat Laporan Baru</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection