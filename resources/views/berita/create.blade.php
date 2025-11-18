@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Form Tulis Berita Baru</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('berita.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label"><strong>Gambar Sampul</strong></label>
                <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar">
                @error('gambar')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Judul Berita</strong></label>
                <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul') }}" placeholder="Masukkan Judul Berita">
                @error('judul')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Isi Berita</strong></label>
                <textarea class="form-control @error('isi') is-invalid @enderror" name="isi" rows="5" placeholder="Masukkan Isi Berita">{{ old('isi') }}</textarea>
                @error('isi')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">SIMPAN</button>
            <a href="{{ route('berita.index') }}" class="btn btn-secondary">KEMBALI</a>
        </form>
    </div>
</div>
@endsection