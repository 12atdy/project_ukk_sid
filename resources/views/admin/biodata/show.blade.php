@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Detail Lengkap Penduduk</h1>
        <a href="{{ route('admin.biodata.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow rounded-3">
        <div class="card-header bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Data Kependudukan</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th width="250">NIK</th>
                                <td>{{ $biodata->nik }}</td>
                            </tr>
                            <tr>
                                <th>Nomor Kartu Keluarga (KK)</th>
                                <td>{{ $biodata->nomor_kk }}</td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>{{ $biodata->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <th>Tempat, Tanggal Lahir</th>
                                <td>{{ $biodata->tempat_lahir }}, {{ \Carbon\Carbon::parse($biodata->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>
                                    @if($biodata->jenis_kelamin == 'Laki-laki')
                                        <span class="badge badge-info">Laki-laki</span>
                                    @else
                                        <span class="badge badge-danger">Perempuan</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Agama</th>
                                <td>{{ $biodata->agama }}</td>
                            </tr>
                            <tr>
                                <th>Status Perkawinan</th>
                                <td>{{ $biodata->status_perkawinan }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Status Kependudukan</th>
                                <td>
                                    @if($biodata->status_kependudukan == 'Tetap')
                                        <span class="badge bg-success">WARGA TETAP</span>
                                    @elseif($biodata->status_kependudukan == 'Pendatang')
                                        <span class="badge bg-warning text-dark">PENDATANG</span>
                                    @else
                                        <span class="badge bg-info text-dark">MUSIMAN</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Pekerjaan</th>
                                <td>{{ $biodata->pekerjaan }}</td>
                            </tr>
                            <tr>
                                <th>Alamat Lengkap</th>
                                <td>{{ $biodata->alamat }}</td>
                            </tr>
                            <tr>
                                <th>Terdaftar Pada</th>
                                <td>{{ $biodata->created_at->translatedFormat('d F Y, H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.biodata.edit', $biodata->id) }}" class="btn btn-warning text-white mr-2">
                    <i class="fas fa-edit me-1"></i> Edit Data
                </a>
                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('admin.biodata.destroy', $biodata->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
