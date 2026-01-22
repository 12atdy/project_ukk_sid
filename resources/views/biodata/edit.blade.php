@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Edit Data Penduduk</h6>
        <a href="{{ route('admin.biodata.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.biodata.update', $biodata->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>NIK</label>
                    <input type="text" name="nik" class="form-control" value="{{ $biodata->nik }}" required maxlength="16">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Nomor KK</label>
                    <input type="text" name="nomor_kk" class="form-control" value="{{ $biodata->nomor_kk }}" required maxlength="16">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ $biodata->nama_lengkap }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="{{ $biodata->tempat_lahir }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ $biodata->tanggal_lahir }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="Laki-laki" {{ $biodata->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ $biodata->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Agama</label>
                    <select name="agama" class="form-control" required>
                        @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $agama)
                            <option value="{{ $agama }}" {{ $biodata->agama == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Status Perkawinan</label>
                    <select name="status_perkawinan" class="form-control" required>
                        @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $status)
                            <option value="{{ $status }}" {{ $biodata->status_perkawinan == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control" value="{{ $biodata->pekerjaan }}" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control" rows="2" required>{{ $biodata->alamat }}</textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">UPDATE DATA</button>
        </form>
    </div>
</div>
@endsection
