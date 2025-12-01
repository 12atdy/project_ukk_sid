@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Dashboard Ringkasan</h1>
            <p class="text-muted small mb-0">Pantau aktivitas desa hari ini, {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
        </div>
    </div>

    <!-- KARTU STATISTIK -->
    <div class="row">
        <!-- Kartu Surat Menunggu -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow h-100 py-2" style="border-left: 5px solid #f6c23e !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Surat Menunggu</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $suratBaru ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-clock fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Pengaduan Baru -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow h-100 py-2" style="border-left: 5px solid #e74a3b !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Aduan Masuk</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $aduanBaru ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-exclamation-triangle fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Surat Selesai -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow h-100 py-2" style="border-left: 5px solid #1cc88a !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Surat Terbit</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $suratSelesai ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Total Warga -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow h-100 py-2" style="border-left: 5px solid #4e73df !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Penduduk</div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $totalWarga ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL RIWAYAT TERBARU -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4 border-0 rounded-3">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-history me-2"></i> Permohonan Terbaru</h6>
                    <a href="{{ route('admin.surat.index') }}" class="btn btn-sm btn-primary rounded-pill px-3">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Pemohon</th>
                                    <th>Jenis Layanan</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($suratTerbaru as $surat)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $surat->user->name }}</div>
                                        <small class="text-muted">NIK: {{ $surat->user->biodata->nik ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ strtoupper(str_replace('_', ' ', $surat->jenis_surat)) }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($surat->tanggal_ajuan)->format('d M Y') }}</td>
                                    <td>
                                        @if($surat->status == 'menunggu')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif($surat->status == 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.surat.show', $surat->id) }}" class="btn btn-sm btn-info text-white rounded-circle" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada permohonan masuk.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection