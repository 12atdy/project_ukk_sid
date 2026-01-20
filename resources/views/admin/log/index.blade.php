@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Log Aktivitas (Realtime Firebase)</h1>
        <span class="badge badge-success px-3 py-2">
            <i class="fas fa-satellite-dish"></i> Live Connection
        </span>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th width="20%">Waktu</th>
                            <th width="25%">Pelaku</th>
                            <th>Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            {{-- WAKTU --}}
                            <td>
                                {{ \Carbon\Carbon::parse($log['waktu'])->isoFormat('D MMMM Y, HH:mm:ss') }}
                            </td>
                            
                            {{-- PELAKU --}}
                            <td>
                                <strong>{{ $log['nama_user'] ?? 'Guest' }}</strong><br>
                                <span class="badge badge-secondary">{{ ucfirst($log['role'] ?? '-') }}</span>
                            </td>

                            {{-- AKTIVITAS --}}
                            <td>
                                {{-- Kalau ada 'aktivitas' tampilkan, kalau nggak ada (data debug) tampilkan 'pesan', kalau kosong semua strip '-' --}}
                                {{ $log['aktivitas'] ?? $log['pesan'] ?? '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center p-4">
                                <em>Belum ada data aktivitas di Firebase.</em>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <small class="text-muted">* Menampilkan 50 aktivitas terakhir dari Cloud.</small>
            </div>
        </div>
    </div>
</div>
@endsection