@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Judul Halaman -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Dashboard Admin</h1>
        <span class="text-muted">{{ now()->translatedFormat('l, d F Y') }}</span>
    </div>

    <!-- Baris Kartu Statistik -->
    <div class="row">

        <!-- Kartu Surat Menunggu (KUNING) -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-4 border-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Surat Menunggu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $suratMenunggu }} Permohonan</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope-open-text fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Pengaduan Baru (MERAH) -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-4 border-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pengaduan Baru</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengaduanBaru }} Laporan</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bullhorn fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Total Warga (BIRU) -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-4 border-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Warga</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalWarga }} Jiwa</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Surat Selesai (HIJAU) -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start border-4 border-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Surat Terbit</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $suratSelesai }} Dokumen</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Surat Terbaru -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Permohonan Surat Terbaru</h6>
            <a href="{{ route('admin.surat.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr class="bg-light">
                            <th>Tanggal</th>
                            <th>Nama Warga</th>
                            <th>Jenis Surat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suratTerbaru as $surat)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($surat->tanggal_ajuan)->format('d/m/Y') }}</td>
                            <td>{{ $surat->user->name }}</td>
                            <td>{{ strtoupper(str_replace('_', ' ', $surat->jenis_surat)) }}</td>
                            <td>
                                <span class="badge {{ $surat->status == 'selesai' ? 'bg-success' : ($surat->status == 'ditolak' ? 'bg-danger' : 'bg-warning') }}">
                                    {{ ucfirst($surat->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.surat.show', $surat->id) }}" class="btn btn-info btn-sm text-white">
                                    <i class="fas fa-eye"></i> Cek
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada permohonan surat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection