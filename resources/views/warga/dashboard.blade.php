@extends('layouts.admin')

@section('content')
<div class="container">
    
    <div class="alert alert-success shadow-sm border-0 mb-4">
        <h4 class="alert-heading fw-bold mb-1">
            <i class="fas fa-smile-beam me-2"></i> Halo, {{ Auth::user()->name }}!
        </h4>
        <p class="mb-0">Selamat datang di layanan mandiri Desa Sidokerto. Apa yang ingin anda urus hari ini?</p>
    </div>

    <div class="row">
        
        <div class="col-md-6 mb-4">
            <div class="card shadow h-100 border-0 border-start border-4 border-primary">
                <div class="card-body">
                    <h6 class="fw-bold text-primary text-uppercase mb-3">
                        <i class="fas fa-envelope me-2"></i> Pengajuan Surat Terakhir
                    </h6>
                    
                    @if($suratTerakhir)
                        <h5 class="fw-bold text-dark mb-1">{{ strtoupper(str_replace('_', ' ', $suratTerakhir->jenis_surat)) }}</h5>
                        <p class="text-muted small mb-2">Diajukan: {{ \Carbon\Carbon::parse($suratTerakhir->tanggal_ajuan)->format('d M Y') }}</p>
                        
                        @if($suratTerakhir->status == 'menunggu')
                            <span class="badge bg-warning text-dark">Sedang Diproses</span>
                        @elseif($suratTerakhir->status == 'selesai')
                            <span class="badge bg-success">Disetujui & Dapat Dicetak</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif

                        <div class="mt-3">
                            <a href="{{ route('surat.index') }}" class="btn btn-sm btn-outline-primary">Lihat Riwayat Lengkap &rarr;</a>
                        </div>
                    @else
                        <p class="text-muted">Anda belum pernah mengajukan surat.</p>
                        <a href="{{ route('surat.create') }}" class="btn btn-sm btn-primary">Ajukan Sekarang</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow h-100 border-0 border-start border-4 border-danger">
                <div class="card-body">
                    <h6 class="fw-bold text-danger text-uppercase mb-3">
                        <i class="fas fa-bullhorn me-2"></i> Laporan Pengaduan Terakhir
                    </h6>

                    @if($aduanTerakhir)
                        <h5 class="fw-bold text-dark mb-1">{{ Str::limit($aduanTerakhir->judul, 30) }}</h5>
                        <p class="text-muted small mb-2">Dilapor: {{ \Carbon\Carbon::parse($aduanTerakhir->tanggal_lapor)->format('d M Y') }}</p>
                        
                        @if($aduanTerakhir->status == 'masuk')
                            <span class="badge bg-warning text-dark">Menunggu Respon</span>
                        @else
                            <span class="badge bg-success">Sudah Ditanggapi</span>
                        @endif

                        <div class="mt-3">
                            <a href="{{ route('pengaduan.index') }}" class="btn btn-sm btn-outline-danger">Cek Tanggapan &rarr;</a>
                        </div>
                    @else
                        <p class="text-muted">Tidak ada laporan pengaduan aktif.</p>
                        <a href="{{ route('pengaduan.create') }}" class="btn btn-sm btn-danger">Buat Laporan</a>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection