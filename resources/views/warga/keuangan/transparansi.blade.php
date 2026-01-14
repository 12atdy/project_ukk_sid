<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transparansi Anggaran Desa Sidokerto</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .hero-section {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            color: white;
            padding: 60px 0;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            margin-bottom: 40px;
        }
        .card-saldo {
            margin-top: -80px;
            background: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <div class="hero-section text-center">
        <div class="container">
            <h1 class="fw-bold display-5 mb-2">Transparansi Anggaran Desa</h1>
            <p class="lead opacity-75">Laporan Keuangan Tahun {{ $tahun }} - Desa Sidokerto</p>
            <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm mt-3 rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <div class="container pb-5">
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card card-saldo p-4 mb-5">
                    <div class="row text-center">
                        <div class="col-md-4 border-end">
                            <h6 class="text-muted text-uppercase small fw-bold">Total Pemasukan</h6>
                            <h3 class="text-success fw-bold">Rp {{ number_format($pemasukan, 0, ',', '.') }}</h3>
                        </div>
                        <div class="col-md-4 border-end">
                            <h6 class="text-muted text-uppercase small fw-bold">Total Pengeluaran</h6>
                            <h3 class="text-danger fw-bold">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h3>
                        </div>
                        <div class="col-md-4">
                            <h6 class="text-muted text-uppercase small fw-bold">Sisa Saldo Kas</h6>
                            <h3 class="text-primary fw-bold">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-history me-2 text-warning"></i> Riwayat Transaksi Terakhir</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-secondary text-uppercase small">
                                    <tr>
                                        <th class="ps-4 py-3">Tanggal</th>
                                        <th class="py-3">Keterangan</th>
                                        <th class="py-3">Jenis</th>
                                        <th class="text-end pe-4 py-3">Nominal (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($riwayat as $item)
                                    <tr>
                                        <td class="ps-4 text-secondary">
                                            {{ \Carbon\Carbon::parse($item->tanggal_transaksi)->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="fw-bold text-dark">
                                            {{ $item->keterangan }}
                                            @if($item->sumber_penerima)
                                                <br><small class="text-muted fw-normal">{{ $item->sumber_penerima }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->jenis_transaksi == 'Pemasukan')
                                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Masuk</span>
                                            @else
                                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Keluar</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4 fw-bold {{ $item->jenis_transaksi == 'Pemasukan' ? 'text-success' : 'text-danger' }}">
                                            {{ $item->jenis_transaksi == 'Pemasukan' ? '+' : '-' }} 
                                            {{ number_format($item->jumlah, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="fas fa-receipt fa-3x mb-3 opacity-25"></i>
                                            <p class="mb-0">Belum ada data transaksi tahun ini.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white text-center py-3 border-top-0">
                        <small class="text-muted">Data diperbarui secara real-time dari Sistem Keuangan Desa.</small>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>