@extends('layouts.app')

@section('content')
<div class="page-header d-flex justify-content-between align-items-start gap-3 flex-wrap">
    <div>
        <div class="page-title"><i class="bi bi-file-earmark-text"></i> Laporan Prioritas Perbaikan</div>
        <p class="page-subtitle">Urutan prioritas berdasarkan nilai MOORA tertinggi.</p>
    </div>
    <a href="{{ route('reports.export.csv') }}" class="btn btn-success">Export CSV</a>
</div>

<div class="card form-shell mb-3">
    <div class="card-body guest-card-inner">
        <p class="mb-0">Laporan ini menampilkan urutan prioritas berdasarkan nilai MOORA tertinggi. CSV bisa dibuka di Excel.</p>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-bordered mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Rank</th>
                    <th>Ruas Jalan</th>
                    <th>Lokasi</th>
                    <th>Nilai MOORA</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($results as $row)
                    <tr>
                        <td>{{ $row['rank'] }}</td>
                        <td>{{ $row['road']->name }}</td>
                        <td>{{ $row['road']->location }}</td>
                        <td>{{ number_format($row['result'], 6) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
