@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Surat Masuk</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengajuan Surat</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Pemohon</th>
                            <th>Jenis Surat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suratMasuk as $index => $surat)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($surat->tanggal_ajuan)->format('d M Y') }}</td>
                            <td>
                                <div class="fw-bold">{{ $surat->user->name ?? 'Warga Terhapus' }}</div>
                                <small class="text-muted">NIK: {{ $surat->user->biodata->nik ?? '-' }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info text-white">{{ strtoupper(str_replace('_', ' ', $surat->jenis_surat)) }}</span>
                            </td>
                            <td>
                                @if($surat->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($surat->status == 'selesai')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.surat.show', $surat->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Periksa
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center p-4">Belum ada pengajuan surat baru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection