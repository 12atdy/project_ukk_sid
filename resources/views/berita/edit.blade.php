@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    
    <!-- Header Page -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold"><i class="fas fa-newspaper me-2"></i> Manajemen Berita</h1>
        <a href="{{ route('berita.create') }}" class="btn btn-primary btn-sm shadow-sm rounded-pill px-3">
            <i class="fas fa-plus fa-sm text-white-50 me-1"></i> Tulis Berita Baru
        </a>
    </div>

    <!-- Content Row -->
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
                        @forelse($semuaBerita as $index => $berita)
                        <tr>
                            <td class="fw-bold text-center">{{ $semuaBerita->firstItem() + $index }}</td>
                            <td>
                                <img src="{{ asset('storage/berita/' . $berita->gambar) }}" 
                                     class="img-fluid rounded shadow-sm" 
                                     style="width: 80px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <h6 class="fw-bold mb-1 text-dark">{{ Str::limit($berita->judul, 50) }}</h6>
                                <p class="small text-muted mb-0">{{ Str::limit($berita->isi, 60) }}</p>
                            </td>
                            <td>
                                <span class="badge bg-secondary fw-normal">
                                    <i class="fas fa-user-edit me-1"></i> {{ $berita->user->name }}
                                </span>
                            </td>
                            <td class="small">
                                <i class="far fa-calendar-alt me-1"></i> {{ $berita->created_at->format('d M Y') }} <br>
                                <span class="text-muted">{{ $berita->created_at->format('H:i') }} WIB</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('berita.edit', $berita->id) }}" class="btn btn-sm btn-outline-info" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="{{ route('berita.destroy', $berita->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus berita ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="mb-3 opacity-25">
                                <p class="mb-0">Belum ada berita yang dipublikasikan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-end">
                {{ $semuaBerita->links() }}
            </div>

        </div>
    </div>
</div>
@endsection