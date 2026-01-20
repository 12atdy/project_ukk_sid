@extends('layouts.admin')

@section('content')
<div class="container pb-5">
    
    <div class="card border-0 shadow-sm mb-4 bg-primary text-white overflow-hidden rounded-3">
        <div class="card-body p-4 position-relative">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="fw-bold mb-1">Halo, {{ Auth::user()->name }}! 👋</h4>
                    <p class="mb-0 opacity-75">Selamat datang di Dashboard Administrator. Pantau aktivitas desa hari ini.</p>
                </div>
                <div class="col-md-4 text-end d-none d-md-block">
                    <i class="fas fa-user-shield fa-4x opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-light rounded-circle p-3 me-3 text-primary">
                        <i class="fas fa-envelope fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0 small">Total Surat</h6>
                        <h3 class="fw-bold mb-0">{{ $totalSurat }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-light rounded-circle p-3 me-3 text-danger">
                        <i class="fas fa-bullhorn fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0 small">Total Aduan</h6>
                        <h3 class="fw-bold mb-0">{{ $totalAduan }}</h3>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow-sm bg-success text-white h-100 overflow-hidden">
                <div class="card-body p-3 position-relative d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="fw-bold mb-1">Keuangan Desa</h4>
                        <p class="mb-0 opacity-75 small">Kelola Data Anggaran & Realisasi</p>
                    </div>
                    {{-- Pastikan route ini benar untuk admin, biasanya admin.keuangan.index --}}
                    <a href="{{ route('admin.keuangan.index') }}" class="btn btn-light text-success fw-bold rounded-pill px-4 shadow-sm stretched-link">
                        Kelola Data <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                    <i class="fas fa-chart-line fa-4x position-absolute opacity-25" style="bottom: -10px; right: 100px; transform: rotate(-15deg);"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow rounded-3 h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
                    <h6 class="fw-bold text-primary m-0"><i class="fas fa-history me-2"></i> Surat Masuk Terbaru</h6>
                    
                    {{-- PERBAIKAN 1: Link diganti ke admin.surat.index --}}
                    <a href="{{ route('admin.surat.index') }}" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                        <i class="fas fa-tasks me-1"></i> Kelola Surat
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 datatable">
                            <thead class="bg-light text-secondary small text-uppercase">
                                <tr>
                                    <th class="ps-4 border-0">Pemohon</th>
                                    <th class="border-0">Jenis Surat</th>
                                    <th class="border-0">Status</th>
                                    <th class="text-center border-0">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @forelse($riwayatSurat as $surat)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $surat->user->name }}</div>
                                        <small class="text-muted" style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($surat->tanggal_ajuan)->format('d M Y') }}</small>
                                    </td>
                                    <td>
                                        <span class="d-block">{{ strtoupper(str_replace('_', ' ', $surat->jenis_surat)) }}</span>
                                        @if($surat->nomor_surat)
                                            <small class="text-muted" style="font-size: 0.75rem;">No: {{ $surat->nomor_surat }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($surat->status == 'menunggu')
                                            <span class="badge bg-warning text-dark rounded-pill px-2">Perlu Cek</span>
                                        @elseif($surat->status == 'selesai')
                                            <span class="badge bg-success rounded-pill px-2">Selesai</span>
                                        @else
                                            <span class="badge bg-danger rounded-pill px-2">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{-- Link ke Detail Admin --}}
                                        <a href="{{ route('admin.surat.show', $surat->id) }}" class="btn btn-sm btn-info text-white rounded-circle" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fas fa-folder-open fa-2x mb-2 opacity-50"></i>
                                        <p class="mb-0 small">Belum ada surat masuk.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white text-center border-0 py-3">
                    {{-- PERBAIKAN 2: Link diganti ke admin.surat.index --}}
                    <a href="{{ route('admin.surat.index') }}" class="text-decoration-none small fw-bold text-primary">Lihat Semua Surat &rarr;</a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="fw-bold text-dark m-0"><i class="fas fa-chart-pie me-2"></i> Statistik Penduduk</h6>
                </div>
                <div class="card-body">
                    <canvas id="grafikGender" style="max-height: 200px;"></canvas>
                </div>
            </div>

            <div class="card border-0 shadow rounded-3">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h6 class="fw-bold text-danger m-0"><i class="fas fa-bullhorn me-2"></i> Aduan Terbaru</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($riwayatAduan as $aduan)
                        <li class="list-group-item p-3 border-bottom-0 border-top">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark small">{{ Str::limit($aduan->judul, 25) }}</h6>
                                    <small class="text-muted d-block" style="font-size: 0.7rem;">
                                        {{ \Carbon\Carbon::parse($aduan->tanggal_lapor)->diffForHumans() }}
                                    </small>
                                </div>
                                @if($aduan->status == 'masuk')
                                    <span class="badge bg-warning text-dark rounded-pill px-2" style="font-size: 0.6rem;">Baru</span>
                                @else
                                    <span class="badge bg-success rounded-pill px-2" style="font-size: 0.6rem;">Direspon</span>
                                @endif
                            </div>
                        </li>
                        @empty
                        <li class="list-group-item text-center py-4 text-muted small">
                            Tidak ada laporan aktif.
                        </li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-body text-center pt-2 pb-4">
                    {{-- Arahkan ke Admin Pengaduan Index --}}
                    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-outline-danger btn-sm w-100 rounded-pill">
                        <i class="fas fa-list me-1"></i> Kelola Aduan
                    </a>
                </div>
            </div>

        </div>

    </div> 
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('grafikGender');
        
        // Data Dummy (akan terganti jika controller mengirim data $laki & $perempuan)
        const dataLaki = {{ $laki ?? 50 }}; 
        const dataPerempuan = {{ $perempuan ?? 40 }};

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [dataLaki, dataPerempuan], 
                    backgroundColor: ['#4e73df', '#e74a3b'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    });
</script>

{{-- PERBAIKAN 3: CSS KHUSUS DATATABLES --}}
<style>
    /* Memberi jarak pada kontrol DataTables (Show entries & Search) */
    .dataTables_wrapper .row:first-child {
        padding: 15px 20px 5px 20px !important; /* Atas Kanan Bawah Kiri */
    }
    
    /* Memberi jarak pada Pagination (Prev - Next) */
    .dataTables_wrapper .row:last-child {
        padding: 5px 20px 15px 20px !important;
    }

    /* Memastikan dropdown length tidak nempel */
    .dataTables_length {
        padding-left: 5px;
    }

    /* Memastikan search tidak nempel */
    .dataTables_filter {
        padding-right: 5px;
    }
</style>
@endsection