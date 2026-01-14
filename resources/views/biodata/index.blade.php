@extends('layouts.admin')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fas fa-users me-2"></i> Data Biodata Penduduk
            </h4>

            <a href="{{ route('admin.biodata.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> Tambah Data Baru
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-center">No.</th>
                            <th scope="col">NIK</th>
                            <th scope="col">Nama Lengkap</th>
                            <th scope="col">Alamat</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data_penduduk as $penduduk)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $penduduk->nik }}</td>
                                <td>{{ $penduduk->nama_lengkap }}</td>
                                <td>{{ $penduduk->alamat }}</td>
                                <td class="text-center">
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" 
                                          {{-- PERBAIKAN: Gunakan 'admin.biodata.destroy' --}}
                                          action="{{ route('admin.biodata.destroy', $penduduk->id) }}" method="POST">
                                        
                                        {{-- PERBAIKAN: Gunakan 'admin.biodata.show' --}}
                                        <a href="{{ route('admin.biodata.show', $penduduk->id) }}" class="btn btn-sm btn-info text-white me-1">
                                            <i class="fas fa-eye"></i> Show
                                        </a>

                                        {{-- PERBAIKAN: Gunakan 'admin.biodata.edit' --}}
                                        <a href="{{ route('admin.biodata.edit', $penduduk->id) }}" class="btn btn-sm btn-warning text-white me-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>

                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <div class="alert alert-warning mb-0">
                                        Data Biodata belum Tersedia.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination Links (Opsional, jika pakai paginate) --}}
            {{-- <div class="mt-3">
                {{ $data_penduduk->links() }}
            </div> --}}
        </div>
    </div>
@endsection