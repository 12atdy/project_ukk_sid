@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Detail Penduduk</h1>
        <a href="{{ route('admin.biodata.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow rounded-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <tr>
                            <th width="200">NIK</th>
                            <td>: {{ $biodata->nik }}</td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>: {{ $biodata->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>: {{ $biodata->alamat }}</td>
                        </tr>
                        <tr>
                            <th>Terdaftar Pada</th>
                            <td>: {{ $biodata->created_at->translatedFormat('d F Y, H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('admin.biodata.edit', $biodata->id) }}" class="btn btn-warning text-white">
                    <i class="fas fa-edit me-1"></i> Edit Data
                </a>
            </div>
        </div>
    </div>

</div>
@endsection