@extends('layouts.admin')

@section('title', 'Tambah Transaksi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Input Keuangan</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.keuangan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Kode Transaksi</label>
                    <input type="text" name="kode_transaksi" class="form-control" placeholder="Contoh: TRX-001" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Transaksi</label>
                    
                    {{-- Input Readonly (Hanya Baca) --}}
                    <input type="date" name="tanggal_display" class="form-control bg-light" 
                        value="{{ date('Y-m-d') }}" readonly>
                        
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i> Tanggal otomatis terisi hari ini dan tidak dapat diubah.
                    </small>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Jenis Transaksi</label>
                    <select name="jenis_transaksi" class="form-control" required>
                        <option value="Pemasukan">Pemasukan (Uang Masuk)</option>
                        <option value="Pengeluaran">Pengeluaran (Uang Keluar)</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Jumlah (Rp)</label>
                    <input type="number" name="jumlah" class="form-control" placeholder="Contoh: 1000000" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Sumber / Penerima</label>
                    <input type="text" name="sumber_penerima" class="form-control" placeholder="Dari siapa atau untuk siapa?" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Penanggung Jawab</label>
                    <input type="text" name="penanggung_jawab" class="form-control" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Keterangan Lengkap</label>
                    <textarea name="keterangan" class="form-control" rows="3" required></textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Bukti / Nota (Foto/PDF)</label>
                    <input type="file" name="bukti" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
            <a href="{{ route('admin.keuangan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@stop