@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold"><i class="fas fa-history me-2"></i> Riwayat Pengajuan Surat</h1>
        <a href="{{ route('surat.create') }}" class="btn btn-primary shadow-sm rounded-pill">
            <i class="fas fa-plus fa-sm text-white-50 me-1"></i> Buat Pengajuan Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow mb-4 border-0 rounded-3">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Surat Saya</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Jenis Surat</th>
                            <th>Tanggal Ajuan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suratSaya as $surat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="fw-bold text-dark">
                                    {{ ucwords(str_replace('_', ' ', $surat->jenis_surat)) }}
                                </span>
                                <br>
                                <small class="text-muted">{{ Str::limit($surat->keterangan, 50) }}</small>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($surat->tanggal_ajuan)->format('d M Y') }}</td>
                            <td>
                                @if($surat->status == 'menunggu')
                                    <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Menunggu Verifikasi</span>
                                @elseif($surat->status == 'selesai')
                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Selesai / Disetujui</span>
                                @elseif($surat->status == 'ditolak')
                                    <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Ditolak</span>
                                @endif
                            </td>
                            <td class="text-center">
    
                                {{-- LOGIKA: Cek Status Dulu --}}
                                
                                @if($surat->status == 'selesai')
                                    
                                    {{-- KONDISI 1: Surat SUDAH SELESAI (Disetujui Admin) --}}
                                    {{-- Tombol Warna HIJAU, Bisa Diklik, Arah ke Route Cetak --}}
                                    <a href="{{ route('surat.cetak_mandiri', $surat->id) }}" target="_blank" class="btn btn-sm btn-success shadow-sm rounded-pill px-3" title="Cetak Surat">
                                        <i class="fas fa-print me-1"></i> Cetak PDF
                                    </a>

                                @elseif($surat->status == 'ditolak')
                                    
                                    {{-- KONDISI 2: Surat DITOLAK --}}
                                    {{-- Tombol MERAH, Disabled (Gak bisa diklik) --}}
                                    <button type="button" class="btn btn-sm btn-danger rounded-pill" disabled title="Pengajuan Ditolak">
                                        <i class="fas fa-times-circle"></i> Ditolak
                                    </button>

                                @else
                                    
                                    {{-- KONDISI 3: Masih MENUNGGU --}}
                                    {{-- Tombol ABU-ABU/KUNING, Disabled (Gak bisa diklik) --}}
                                    <button type="button" class="btn btn-sm btn-secondary rounded-pill" disabled title="Menunggu Verifikasi">
                                        <i class="fas fa-hourglass-half"></i> Proses...
                                    </button>
                                    
                                @endif

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="mb-3 opacity-50">
                                <p class="text-muted mb-0">Anda belum pernah mengajukan surat.</p>
                                <a href="{{ route('surat.create') }}" class="btn btn-link text-decoration-none">Ajukan Sekarang</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection