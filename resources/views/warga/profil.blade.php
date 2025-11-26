@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i> Lengkapi Biodata Diri</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('warga.profil.update') }}" method="POST">
                        @csrf
                        
                        <div class="alert alert-info small">
                            <i class="fas fa-info-circle"></i> Data ini akan otomatis dipakai saat Anda mengajukan surat.
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap (Sesuai Akun)</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->name }}" readonly>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">NIK</label>
                                <input type="number" name="nik" class="form-control" value="{{ $biodata->nik }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki" {{ $biodata->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ $biodata->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" value="{{ $biodata->tempat_lahir }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" value="{{ $biodata->tanggal_lahir }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control" value="{{ $biodata->pekerjaan }}" placeholder="Contoh: Wiraswasta" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Alamat Lengkap (Sesuai KTP)</label>
                            <textarea name="alamat" class="form-control" rows="3" required>{{ $biodata->alamat }}</textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> SIMPAN BIODATA
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection