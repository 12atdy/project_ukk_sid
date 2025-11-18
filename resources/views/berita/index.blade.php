@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-newspaper me-2"></i> Kelola Berita Desa</h4>
            <a href="{{ route('berita.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle me-1"></i> Tulis Berita Baru</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Gambar</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Penulis</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($semuaBerita as $berita)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    <img src="{{ asset('storage/berita/'.$berita->gambar) }}" class="rounded" style="width: 150px">
                                </td>
                                <td>{{ $berita->judul }}</td>
                                <td>{{ $berita->user?->name ?? 'Tanpa Penulis' }}</td>
                                <td class="text-center">
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('berita.destroy', $berita->id) }}" method="POST">
                                        <a href="{{ route('berita.edit', $berita->id) }}" class="btn btn-sm btn-warning">EDIT</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <div class="alert alert-danger">Data berita belum tersedia.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection