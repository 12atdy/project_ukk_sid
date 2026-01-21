@extends('layouts.admin')

@section('title', 'Tambah Transaksi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Form Input Keuangan</h3>
    </div>
    <div class="card-body">
        
        {{-- [TAMBAHAN] Tampilkan Pesan Error Validasi Disini --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.keuangan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Kode Transaksi</label>
                    <input type="text" name="kode_transaksi" class="form-control" placeholder="Contoh: TRX-001" value="{{ old('kode_transaksi') }}" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Transaksi</label>
                    
                    {{-- [PERBAIKAN] Ganti name jadi 'tanggal_transaksi' --}}
                    <input type="date" name="tanggal_transaksi" class="form-control bg-light" 
                        value="{{ date('Y-m-d') }}" readonly>
                        
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i> Tanggal otomatis terisi hari ini dan tidak dapat diubah.
                    </small>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jenis Transaksi</label>
                    <select name="jenis_transaksi" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="Pemasukan" {{ old('jenis_transaksi') == 'Pemasukan' ? 'selected' : '' }}>Pemasukan (Uang Masuk)</option>
                        <option value="Pengeluaran" {{ old('jenis_transaksi') == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran (Uang Keluar)</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jumlah (Rp)</label>
                    <input type="number" name="jumlah" class="form-control" placeholder="Contoh: 1000000" value="{{ old('jumlah') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Sumber / Penerima</label>
                    <input type="text" name="sumber_penerima" class="form-control" placeholder="Dari siapa atau untuk siapa?" value="{{ old('sumber_penerima') }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Penanggung Jawab</label>
                    <input type="text" name="penanggung_jawab" class="form-control" value="{{ old('penanggung_jawab') }}" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Keterangan Lengkap</label>
                    <textarea name="keterangan" class="form-control" rows="3" required>{{ old('keterangan') }}</textarea>
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