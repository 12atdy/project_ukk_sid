@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Data Penduduk</h6>
        <a href="{{ route('admin.biodata.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.biodata.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>NIK (16 Digit)</label>
                    <input type="text" name="nik" class="form-control" required maxlength="16" placeholder="Contoh: 3515xxxxxxxxxxxx">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Nomor KK (16 Digit)</label>
                    <input type="text" name="nomor_kk" class="form-control" required maxlength="16" placeholder="Contoh: 3515xxxxxxxxxxxx">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Agama</label>
                    <select name="agama" class="form-control" required>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Status Perkawinan</label>
                    <select name="status_perkawinan" class="form-control" required>
                        <option value="Belum Kawin">Belum Kawin</option>
                        <option value="Kawin">Kawin</option>
                        <option value="Cerai Hidup">Cerai Hidup</option>
                        <option value="Cerai Mati">Cerai Mati</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control" required placeholder="Contoh: Petani / Wiraswasta">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control" rows="2" required></textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">SIMPAN DATA</button>
        </form>
    </div>
</div>
@endsection
