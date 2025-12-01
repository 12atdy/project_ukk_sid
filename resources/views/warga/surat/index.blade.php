@extends('layouts.admin')

@section('content')
<div class="container">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary m-0"><i class="fas fa-history me-2"></i> Riwayat Pengajuan Surat</h4>
        <a href="{{ route('surat.create') }}" class="btn btn-success shadow-sm">
            <i class="fas fa-plus me-1"></i> Ajukan Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse($suratSaya as $surat)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100 rounded-3 border-start border-4 
                {{ $surat->status == 'menunggu' ? 'border-warning' : ($surat->status == 'selesai' ? 'border-success' : 'border-danger') }}">
                
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <small class="text-muted fw-bold">
                            <i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($surat->tanggal_ajuan)->format('d M Y') }}
                        </small>
                        
                        @if($surat->status == 'menunggu')
                            <span class="badge bg-warning text-dark rounded-pill">Proses</span>
                        @elseif($surat->status == 'selesai')
                            <span class="badge bg-success rounded-pill">Selesai</span>
                        @else
                            <span class="badge bg-danger rounded-pill">Ditolak</span>
                        @endif
                    </div>

                    <h5 class="card-title fw-bold text-dark mb-1">
                        {{ strtoupper(str_replace('_', ' ', $surat->jenis_surat)) }}
                    </h5>
                    
                    @if($surat->nomor_surat)
                    <p class="small text-muted mb-2"><i class="fas fa-barcode me-1"></i> No: {{ $surat->nomor_surat }}</p>
                    @else
                    <p class="small text-muted mb-2 fst-italic">Nomor belum diterbitkan</p>
                    @endif

                    @if($surat->keterangan)
                        <div class="bg-light p-2 rounded small mb-3 text-secondary">
                            <i class="fas fa-comment-alt me-1"></i> "{{ Str::limit($surat->keterangan, 50) }}"
                        </div>
                    @endif
                </div>

                <div class="card-footer bg-white border-0 pt-0 pb-3">
                    @if($surat->status == 'selesai')
                        <div class="d-grid">
                            <button class="btn btn-outline-success btn-sm" disabled>
                                <i class="fas fa-check"></i> Surat Siap Diambil / Dicetak
                            </button>
                        </div>
                    @elseif($surat->status == 'ditolak')
                        <div class="d-grid">
                            <button class="btn btn-outline-danger btn-sm" disabled>
                                <i class="fas fa-times"></i> Perbaiki Data
                            </button>
                        </div>
                    @else
                        <div class="d-grid">
                            <button class="btn btn-outline-warning text-dark btn-sm" disabled>
                                <i class="fas fa-clock"></i> Menunggu Verifikasi
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5 bg-white rounded-3 shadow-sm">
                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" width="100" class="mb-3 opacity-50">
                <h5 class="text-muted fw-bold">Belum ada riwayat surat.</h5>
                <p class="text-muted small">Mulai ajukan surat pertama anda sekarang.</p>
                <a href="{{ route('surat.create') }}" class="btn btn-primary mt-2">Buat Pengajuan</a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection