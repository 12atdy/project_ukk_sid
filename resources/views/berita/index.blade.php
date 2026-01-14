@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold"><i class="fas fa-newspaper me-2"></i> Manajemen Berita</h1>
        
        {{-- PERBAIKAN: Gunakan 'admin.berita.create' --}}
        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary btn-sm shadow-sm rounded-pill px-3">
            <i class="fas fa-plus fa-sm text-white-50 me-1"></i> Tulis Berita Baru
        </a>
    </div>

    <div class="card border-0 shadow rounded-3">
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light text-uppercase small text-muted">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Gambar</th>
                            <th width="40%">Judul & Cuplikan</th>
                            <th width="15%">Penulis</th>
                            <th width="15%">Tanggal</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($semuaBerita as $berita)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($berita->gambar)
                                    <img src="{{ asset('storage/' . $berita->gambar) }}" class="img-thumbnail rounded" style="width: 80px; height: 60px; object-fit: cover;">
                                @else
                                    <span class="badge bg-secondary">No Image</span>
                                @endif
                            </td>
                            <td>
                                <h6 class="mb-1 fw-bold text-dark">{{ $berita->judul }}</h6>
                                <p class="text-muted small mb-0">{{ Str::limit(strip_tags($berita->isi), 80) }}</p>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark bg-opacity-10 text-primary px-2 py-1 rounded-pill">
                                    <i class="fas fa-user-circle me-1"></i> {{ $berita->penulis->name }}
                                </span>
                            </td>
                            <td class="small text-secondary">
                                <i class="far fa-calendar-alt me-1"></i> {{ $berita->created_at->format('d M Y') }}<br>
                                <i class="far fa-clock me-1"></i> {{ $berita->created_at->format('H:i') }}
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    {{-- PERBAIKAN: Gunakan 'admin.berita.edit' --}}
                                    <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- PERBAIKAN: Gunakan 'admin.berita.destroy' --}}
                                    <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="if(confirm('Yakin hapus?')) this.form.submit()" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="60" class="mb-3 opacity-50">
                                <p class="mb-0">Belum ada berita yang diterbitkan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $semuaBerita->links() }}
            </div>

        </div>
    </div>

</div>
@endsection