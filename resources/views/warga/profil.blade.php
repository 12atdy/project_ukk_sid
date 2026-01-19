@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card border-0 shadow rounded-3">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-user-edit me-2"></i> Update Biodata Diri</h5>
                </div>
                <div class="card-body p-4">
                    
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm mb-4">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('warga.profil.update') }}" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            <!-- Informasi Dasar -->
                            <div class="col-12"><h6 class="text-muted fw-bold border-bottom pb-2">Informasi Kependudukan</h6></div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-bold">NIK (Nomor Induk Kependudukan)</label>
                                <input type="number" name="nik" class="form-control" value="{{ old('nik', $biodata->nik) }}" required>
                                <div class="form-text text-primary small">
                                    <i class="fas fa-info-circle"></i> Wajib 16 digit angka sesuai KTP.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nomor KK</label>
                                <input type="number" name="no_kk" class="form-control" value="{{ old('no_kk', $biodata->no_kk) }}">
                                <div class="form-text text-primary small">
                                    <i class="fas fa-info-circle"></i> Wajib 16 digit angka sesuai KK.
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">Nama Lengkap (Sesuai KTP)</label>
                                <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $biodata->nama_lengkap ?? Auth::user()->name) }}" required>
                            </div>

                            <!-- Detail Kelahiran -->
                            <div class="col-12 mt-4"><h6 class="text-muted fw-bold border-bottom pb-2">Detail Pribadi</h6></div>

                            <div class="col-md-6">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $biodata->tempat_lahir) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $biodata->tanggal_lahir) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    <option value="Laki-laki" {{ (old('jenis_kelamin', $biodata->jenis_kelamin) == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ (old('jenis_kelamin', $biodata->jenis_kelamin) == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Agama</label>
                                <select name="agama" class="form-select">
                                    <option value="Islam" {{ (old('agama', $biodata->agama) == 'Islam') ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ (old('agama', $biodata->agama) == 'Kristen') ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ (old('agama', $biodata->agama) == 'Katolik') ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ (old('agama', $biodata->agama) == 'Hindu') ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ (old('agama', $biodata->agama) == 'Buddha') ? 'selected' : '' }}>Buddha</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status Perkawinan</label>
                                <select name="status_perkawinan" class="form-select">
                                    <option value="Belum Kawin" {{ (old('status_perkawinan', $biodata->status_perkawinan) == 'Belum Kawin') ? 'selected' : '' }}>Belum Kawin</option>
                                    <option value="Kawin" {{ (old('status_perkawinan', $biodata->status_perkawinan) == 'Kawin') ? 'selected' : '' }}>Kawin</option>
                                    <option value="Cerai Hidup" {{ (old('status_perkawinan', $biodata->status_perkawinan) == 'Cerai Hidup') ? 'selected' : '' }}>Cerai Hidup</option>
                                    <option value="Cerai Mati" {{ (old('status_perkawinan', $biodata->status_perkawinan) == 'Cerai Mati') ? 'selected' : '' }}>Cerai Mati</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $biodata->pekerjaan) }}" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $biodata->alamat) }}</textarea>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg shadow fw-bold">
                                <i class="fas fa-save me-2"></i> SIMPAN PERUBAHAN
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection