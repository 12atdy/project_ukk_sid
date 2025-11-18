@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Form Edit Berita</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="mb-3">
                <label class="form-label"><strong>Gambar Sampul</strong></label>
                <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar">
                <div class="mt-2">
                    <img src="{{ asset('storage/berita/'.$berita->gambar) }}" width="150" class="rounded">
                </div>
                @error('gambar')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Judul Berita</strong></label>
                <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul', $berita->judul) }}" placeholder="Masukkan Judul Berita">
                @error('judul')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Isi Berita</strong></label>
                <textarea class="form-control @error('isi') is-invalid @enderror" name="isi" rows="5" placeholder="Masukkan Isi Berita">{{ old('isi', $berita->isi) }}</textarea>
                @error('isi')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">UPDATE PERUBAHAN</button>
            <a href="{{ route('berita.index') }}" class="btn btn-secondary">KEMBALI</a>
        </form>
    </div>
</div>
@endsection