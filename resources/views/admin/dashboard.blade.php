@extends('layouts.admin')

@section('content')
<div class="container-fluid pb-4">

    <div class="card shadow mb-4 bg-primary text-white" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-4 position-relative">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="font-weight-bold mb-1">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="mb-0 text-white-50">Selamat datang di Dashboard Administrator. Pantau aktivitas desa hari ini.</p>
                </div>
                <div class="col-md-4 text-right d-none d-md-block">
                    <i class="fas fa-user-shield fa-4x text-white-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Surat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSurat }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Aduan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAduan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bullhorn fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-12 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Keuangan Desa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Kelola Anggaran</div>
                    </div>
                    <a href="{{ route('admin.keuangan.index') }}" class="btn btn-success btn-sm shadow-sm">
                        Kelola Data <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Surat Masuk Terbaru</h6>
                    <a href="{{ route('admin.surat.index') }}" class="btn btn-sm btn-primary shadow-sm">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="pl-4">Pemohon</th>
                                    <th>Jenis</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayatSurat as $surat)
                                <tr>
                                    <td class="pl-4 font-weight-bold">{{ $surat->user->name }}</td>
                                    <td>{{ Str::limit(str_replace('_', ' ', $surat->jenis_surat), 15) }}</td>
                                    <td>
                                        @if($surat->status == 'menunggu')
                                            <span class="badge badge-warning">Cek</span>
                                        @elseif($surat->status == 'selesai')
                                            <span class="badge badge-success">Selesai</span>
                                        @else
                                            <span class="badge badge-danger">Tolak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.surat.show', $surat->id) }}" class="btn btn-info btn-circle btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada surat masuk.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark">Statistik Penduduk</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="grafikGender"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Laki-laki
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-danger"></i> Perempuan
                        </span>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">Aduan Terbaru</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($riwayatAduan as $aduan)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="text-truncate font-weight-bold" style="max-width: 150px;">{{ $aduan->judul }}</div>
                                <div class="small text-gray-500">{{ \Carbon\Carbon::parse($aduan->tanggal_lapor)->diffForHumans() }}</div>
                            </div>
                            @if($aduan->status == 'masuk')
                                <span class="badge badge-warning">Baru</span>
                            @else
                                <span class="badge badge-success">Respon</span>
                            @endif
                        </li>
                        @empty
                        <li class="list-group-item text-center small text-muted">Tidak ada aduan.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById("grafikGender");
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Laki-laki", "Perempuan"],
                datasets: [{
                    data: [{{ $laki ?? 0 }}, {{ $perempuan ?? 0 }}],
                    backgroundColor: ['#0f2568', '#e74a3b'],
                    hoverBackgroundColor: ['#2e59d9', '#e74a3b'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 80,
            },
        });
    });
</script>
@endsection