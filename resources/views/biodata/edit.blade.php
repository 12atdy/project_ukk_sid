@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-edit me-2"></i> Form Edit Data Penduduk</h4>
            <a href="{{ route('biodata.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
        </div>
        <div class="card-body">
            {{-- Arahkan action ke route 'update' dengan mengirimkan ID --}}
            <form action="{{ route('admin.biodata.update', $biodata->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Method khusus untuk update --}}

                <div class="mb-3">
                    <label for="nik" class="form-label"><strong>NIK</strong></label>
                    {{-- Tampilkan data lama di 'value' --}}
                    <input type="text" id="nik" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $biodata->nik) }}" required>
                    @error('nik')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label"><strong>Nama Lengkap</strong></label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $biodata->nama_lengkap) }}" required>
                    @error('nama_lengkap')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label"><strong>Alamat</strong></label>
                    <textarea id="alamat" name="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat', $biodata->alamat) }}</textarea>
                    @error('alamat')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-save me-1"></i> UPDATE DATA
                </button>
            </form>
        </div>
    </div>
@endsection