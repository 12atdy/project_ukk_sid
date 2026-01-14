@extends('layouts.admin')

@section('title', 'Kelola Keuangan Desa')

@section('content_header')
    <h1>Keuangan Desa</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>Rp {{ number_format($pemasukan, 0, ',', '.') }}</h3>
                <p>Total Pemasukan</p>
            </div>
            <div class="icon"><i class="fas fa-arrow-up"></i></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h3>
                <p>Total Pengeluaran</p>
            </div>
            <div class="icon"><i class="fas fa-arrow-down"></i></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                <p>Sisa Saldo Kas</p>
            </div>
            <div class="icon"><i class="fas fa-wallet"></i></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.keuangan.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Transaksi</a>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kode</th>
                    <th>Jenis</th>
                    <th>Keterangan</th>
                    <th>Jumlah (Rp)</th>
                    <th>Bukti</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d-m-Y') }}</td>
                    <td>{{ $item->kode_transaksi }}</td>
                    <td>
                        <span class="badge {{ $item->jenis_transaksi == 'Pemasukan' ? 'bg-success' : 'bg-danger' }}">
                            {{ $item->jenis_transaksi }}
                        </span>
                    </td>
                    <td>{{ $item->keterangan }}<br><small class="text-muted">PJ: {{ $item->penanggung_jawab }}</small></td>
                    <td class="text-end fw-bold">{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td>
                        @if($item->bukti)
                            <a href="{{ asset('storage/'.$item->bukti) }}" target="_blank" class="btn btn-xs btn-secondary"><i class="fas fa-image"></i> Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.keuangan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $data->links() }}
        </div>
    </div>
</div>
@stop