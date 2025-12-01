@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Catatan Aktivitas Sistem (Log)</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped" width="100%">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>Waktu</th>
                            <th>Pelaku (User)</th>
                            <th>Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td width="200">{{ $log->created_at->format('d M Y, H:i:s') }}</td>
                            <td width="250">
                                <strong>{{ $log->user->name ?? 'Guest' }}</strong><br>
                                <small class="text-muted">{{ $log->user->role ?? '-' }}</small>
                            </td>
                            <td>{{ $log->aktivitas }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection