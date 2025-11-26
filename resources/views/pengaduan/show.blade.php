@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <a href="{{ Auth::user()->role == 'admin' ? route('admin.pengaduan.index') : route('pengaduan.index') }}" class="btn btn-secondary mb-3 btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 45px; height: 45px;">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $pengaduan->user->name }}</h6>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($pengaduan->tanggal_lapor)->format('d M Y, H:i') }}</small>
                        </div>
                    </div>
                    <span class="badge {{ $pengaduan->status == 'selesai' ? 'bg-success' : 'bg-warning' }}">{{ strtoupper($pengaduan->status) }}</span>
                    </div>
                <div class="card-body">
                    <h5 class="fw-bold">{{ $pengaduan->judul }}</h5>
                    <p class="text-dark">{{ $pengaduan->isi_pengaduan }}</p>
                    
                    @if($pengaduan->foto_bukti)
                        <div class="mt-3">
                            <p class="fw-bold small mb-1">Bukti Foto:</p>
                            <img src="{{ asset('storage/' . $pengaduan->foto_bukti) }}" class="img-fluid rounded border" style="max-height: 300px;">
                        </div>
                    @endif
                </div>
            </div>

            @if($pengaduan->tanggapan)
                <div class="card shadow-sm border-0 border-start border-5 border-success bg-light">
                    <div class="card-body">
                        <h6 class="fw-bold text-success"><i class="fas fa-check-circle me-2"></i> Tanggapan Petugas ({{ $pengaduan->tanggapan->admin->name }})</h6>
                        <p class="mb-1">{{ $pengaduan->tanggapan->isi_tanggapan }}</p>
                        <small class="text-muted text-end d-block">{{ \Carbon\Carbon::parse($pengaduan->tanggapan->tanggal_tanggapan)->format('d M Y, H:i') }}</small>
                    </div>
                </div>
            @elseif(Auth::user()->role == 'admin')
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><i class="fas fa-pen me-2"></i> Berikan Tanggapan</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.pengaduan.tanggapi', $pengaduan->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea name="isi_tanggapan" class="form-control" rows="3" placeholder="Tulis respon anda di sini..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-info text-white fw-bold">Kirim Tanggapan</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-clock me-2"></i> Laporan Anda sedang menunggu respon dari petugas desa.
                </div>
            @endif

        </div>
    </div>
</div>
@endsection