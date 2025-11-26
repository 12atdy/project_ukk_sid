@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-primary fw-bold">Riwayat Pengaduan Saya</h4>
        <a href="{{ route('pengaduan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Buat Laporan Baru
        </a>
    </div>

    <div class="row">
        @forelse($pengaduan as $item)
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100 border-start border-4 {{ $item->status == 'selesai' ? 'border-success' : 'border-warning' }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title fw-bold">{{ $item->judul }}</h5>
                        <span class="badge {{ $item->status == 'selesai' ? 'bg-success' : 'bg-warning' }}">{{ ucfirst($item->status) }}</span>
                    </div>
                    <p class="text-muted small mb-2">{{ \Carbon\Carbon::parse($item->tanggal_lapor)->format('d M Y, H:i') }}</p>
                    <p class="card-text text-truncate">{{ $item->isi_pengaduan }}</p>
                    
                    <!-- TOMBOL DIPERBAIKI: Mengarah ke route khusus warga -->
                    <a href="{{ route('warga.pengaduan.show', $item->id) }}" class="btn btn-sm btn-outline-primary stretched-link">Lihat Detail & Respon</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="100" class="mb-3 opacity-50">
            <p class="text-muted">Belum ada pengaduan yang kamu buat.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection