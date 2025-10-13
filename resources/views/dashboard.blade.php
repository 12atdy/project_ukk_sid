@extends('layouts.admin')

@section('content')
<h1 class="h2">Dashboard</h1>
<p>Selamat datang kembali, {{ Auth::user()->name }}!</p>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Penduduk</div>
            <div class="card-body">
                <h5 class="card-title">Kelola Biodata Penduduk</h5>
                <p class="card-text">Tambah, edit, atau hapus data penduduk Desa Sidokerto.</p>
                <a href="{{ route('biodata.index') }}" class="btn btn-light">Biodata penduduk <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Berita</div>
            <div class="card-body">
                <h5 class="card-title">Kelola Berita Desa</h5>
                <p class="card-text">Publikasikan pengumuman dan berita terbaru untuk warga.</p>
                <a href="#" class="btn btn-light">Berita Desa <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    </div>
@endsection