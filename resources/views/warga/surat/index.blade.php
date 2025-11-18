@extends('layouts.admin')

@section('content')
<div class="container">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-history me-2"></i> Riwayat Pengajuan Surat</h5>
            <a href="{{ route('surat.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                <i class="fas fa-plus me-1"></i> Ajukan Baru
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="py-3">Jenis Surat</th>
                            <th class="py-3">Tanggal Ajuan</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suratSaya as $surat)
                            <tr>
                                <td class="px-4">{{ $loop->iteration }}</td>
                                <td class="fw-bold">{{ $surat->jenis_surat }}</td>
                                <td>{{ \Carbon\Carbon::parse($surat->tanggal_ajuan)->format('d M Y') }}</td>
                                <td>
                                    @if($surat->status == 'menunggu')
                                        <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Menunggu</span>
                                    @elseif($surat->status == 'diproses')
                                        <span class="badge bg-info"><i class="fas fa-spinner fa-spin me-1"></i> Diproses</span>
                                    @elseif($surat->status == 'selesai')
                                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Selesai</span>
                                    @elseif($surat->status == 'ditolak')
                                        <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-muted small">
                                    {{ $surat->keterangan_admin ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" width="80" class="mb-3 opacity-50" alt="Kosong">
                                    <br>
                                    Belum ada pengajuan surat. <br>
                                    <a href="{{ route('surat.create') }}" class="text-decoration-none">Buat pengajuan sekarang</a>
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