@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title"><i class="bi bi-graph-up"></i> Hasil Perhitungan MOORA</div>
    <p class="page-subtitle">Nilai benefit dikurangi cost untuk menentukan prioritas perbaikan.</p>
</div>

<div class="card form-shell mb-3">
    <div class="card-body guest-card-inner">
        <p class="mb-1">Rumus singkat:</p>
        <p class="mb-0">$$Y_i = \sum_{j=1}^{g} w_j x_{ij} - \sum_{j=g+1}^{n} w_j x_{ij}$$</p>
        <small class="text-muted">Benefit dijumlahkan, cost dikurangkan.</small>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-bordered mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Rank</th>
                    <th>Ruas Jalan</th>
                    <th>Benefit</th>
                    <th>Cost</th>
                    <th>Nilai Akhir</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($results as $row)
                    <tr>
                        <td>{{ $row['rank'] }}</td>
                        <td>
                            <strong>{{ $row['road']->name }}</strong><br>
                            <small class="text-muted">{{ $row['road']->location }}</small>
                        </td>
                        <td>{{ number_format($row['benefit_total'], 6) }}</td>
                        <td>{{ number_format($row['cost_total'], 6) }}</td>
                        <td><span class="badge bg-primary">{{ number_format($row['result'], 6) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data untuk dihitung.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
