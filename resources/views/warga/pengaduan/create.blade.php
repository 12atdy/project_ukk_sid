@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0" style="max-width: 700px; margin: 0 auto;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-danger"><i class="fas fa-bullhorn me-2"></i> Form Pengaduan Masyarakat</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Laporan</label>
                    <input type="text" name="judul_laporan" class="form-control" placeholder="Contoh: Jalan Berlubang di RT 05" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Isi Laporan Lengkap</label>
                    <textarea name="isi_laporan" class="form-control" rows="5" placeholder="Jelaskan detail kejadian, lokasi, dan harapan anda..." required></textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Bukti Foto (Opsional)</label>
                    <input type="file" name="foto_bukti" class="form-control" accept="image/*">
                    <small class="text-muted">Maksimal 2MB (JPG/PNG)</small>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-danger btn-lg">KIRIM LAPORAN</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection