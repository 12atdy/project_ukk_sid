@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Kotak Pengaduan Masuk</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Pelapor</th>
                            <th>Judul Masalah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengaduan as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_lapor)->format('d/m/Y') }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ Str::limit($item->judul, 40) }}</td>
                            <td>
                                @if($item->status == 'masuk')
                                    <span class="badge bg-warning text-dark">Belum Direspon</span>
                                @else
                                    <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>
                            <td>
                                <!-- TOMBOL DIPERBAIKI: Mengarah ke route admin -->
                                <a href="{{ route('admin.pengaduan.show', $item->id) }}" class="btn btn-info btn-sm text-white">
                                    <i class="fas fa-reply"></i> Lihat & Balas
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center">Tidak ada pengaduan masuk.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection