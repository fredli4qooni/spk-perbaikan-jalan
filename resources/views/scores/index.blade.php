@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title"><i class="bi bi-card-checklist"></i> Input Nilai Alternatif</div>
    <p class="page-subtitle">Isi nilai untuk setiap ruas jalan dan kriteria dengan skala numerik yang konsisten.</p>
</div>

@if ($roads->isEmpty() || $criteria->isEmpty())
    <div class="alert alert-warning">Data ruas jalan dan kriteria harus tersedia terlebih dahulu.</div>
@else
    <div class="card form-shell mb-3">
        <div class="card-body guest-card-inner">
            <p class="mb-0">Isi nilai untuk setiap ruas jalan dan kriteria. Untuk tingkat kerusakan, gunakan skala numerik yang konsisten, misalnya 1 = ringan, 2 = sedang, 3 = berat.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('scores.store') }}">
        @csrf
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ruas Jalan</th>
                            @foreach ($criteria as $criterion)
                                <th>{{ $criterion->code }}<br>{{ $criterion->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roads as $road)
                            <tr>
                                <td>
                                    <strong>{{ $road->name }}</strong><br>
                                    <small class="text-muted">{{ $road->location }}</small>
                                </td>
                                @foreach ($criteria as $criterion)
                                    @php
                                        $current = old('scores.' . $road->id . '.' . $criterion->id, optional($road->scores->firstWhere('criterion_id', $criterion->id))->value);
                                    @endphp
                                    <td style="min-width: 150px;">
                                        <input type="number" step="0.01" min="0" name="scores[{{ $road->id }}][{{ $criterion->id }}]" class="form-control" value="{{ $current }}">
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <button class="btn btn-primary mt-3">Simpan Nilai</button>
    </form>
@endif
@endsection
