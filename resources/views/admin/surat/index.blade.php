@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold"><i class="fas fa-inbox me-2"></i> Kotak Surat Masuk</h1>
    </div>

    <div class="card border-0 shadow rounded-3">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 fw-bold text-primary">Daftar Permohonan Warga</h6>
        </div>
        <div class="card-body">
            
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle w-100" id="dataTable" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal & Waktu</th>
                            <th>Pemohon</th>
                            <th>Jenis Surat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suratMasuk as $index => $surat)
                        <tr>
                            <td class="text-center fw-bold">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold">{{ \Carbon\Carbon::parse($surat->tanggal_ajuan)->format('d M Y') }}</div>
                                <small class="text-muted">{{ $surat->created_at->format('H:i') }} WIB</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                        {{ substr($surat->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $surat->user->name }}</div>
                                        <div class="small text-muted">NIK: {{ $surat->user->biodata->nik ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border border-secondary fw-normal">
                                    {{ strtoupper(str_replace('_', ' ', $surat->jenis_surat)) }}
                                </span>
                            </td>
                            <td>
                                @if($surat->status == 'menunggu')
                                    <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Menunggu</span>
                                @elseif($surat->status == 'selesai')
                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Selesai</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.surat.show', $surat->id) }}" class="btn btn-sm btn-primary shadow-sm px-3">
                                    <i class="fas fa-search me-1"></i> Periksa
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                                <p class="text-muted">Tidak ada surat masuk saat ini.</p>
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