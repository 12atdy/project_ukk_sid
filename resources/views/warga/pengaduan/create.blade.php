@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card border-0 shadow rounded-4 overflow-hidden">
                <div class="card-header bg-danger text-white p-4 text-center">
                    <h2 class="mb-1"><i class="fas fa-bullhorn fa-lg"></i></h2>
                    <h4 class="fw-bold mb-0">Layanan Aspirasi & Pengaduan</h4>
                    <p class="mb-0 small opacity-75">Sampaikan masalah lingkungan anda, kami siap membantu.</p>
                </div>

                <div class="card-body p-5 bg-white">
                    
                    <div class="alert alert-warning d-flex align-items-center shadow-sm border-0 mb-4" role="alert">
                        <i class="fas fa-exclamation-triangle fa-2x me-3 text-warning"></i>
                        <div>
                            <strong>Penting:</strong> Laporan anda akan tercatat di sistem. Gunakan bahasa yang sopan dan sertakan bukti foto yang valid.
                        </div>
                    </div>

                    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-floating mb-3">
                            <input type="text" name="judul_laporan" class="form-control" id="floatingInput" placeholder="Contoh: Jalan Berlubang" required>
                            <label for="floatingInput">Judul Laporan / Masalah</label>
                        </div>

                        <div class="form-floating mb-4">
                            <textarea name="isi_laporan" class="form-control" placeholder="Jelaskan detailnya..." id="floatingTextarea" style="height: 150px" required></textarea>
                            <label for="floatingTextarea">Jelaskan detail kejadian, lokasi, dan waktu...</label>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary"><i class="fas fa-camera me-1"></i> Bukti Foto (Wajib/Opsional)</label>
                            <div class="input-group">
                                <input type="file" name="foto_bukti" class="form-control" id="inputGroupFile02">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>
                            <div class="form-text">Format: JPG, PNG. Maksimal 2MB.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-danger btn-lg shadow fw-bold">
                                <i class="fas fa-paper-plane me-2"></i> KIRIM LAPORAN SEKARANG
                            </button>
                            <a href="{{ route('pengaduan.index') }}" class="btn btn-light text-muted">Batal & Kembali</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection