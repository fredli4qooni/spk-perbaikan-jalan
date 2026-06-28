@extends('layouts.app')

@section('content')
<div class="mb-3">
    <h2 class="h4 mb-0"><i class="bi bi-speedometer2"></i> Dashboard</h2>
    <small class="text-muted">Ringkasan sistem MOORA</small>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-3">
        <div class="card h-100 border-0">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Total Ruas Jalan</div>
                    <div class="display-6 fw-bold">{{ $roadCount }}</div>
                </div>
                <div style="font-size: 3rem; color: #0d6efd; opacity: 0.2;">
                    <i class="bi bi-road-lane"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card h-100 border-0">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Total Kriteria</div>
                    <div class="display-6 fw-bold">{{ $criterionCount }}</div>
                </div>
                <div style="font-size: 3rem; color: #0dcaf0; opacity: 0.2;">
                    <i class="bi bi-list-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card h-100 border-0">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Prioritas 1</div>
                    <div class="h5 fw-bold mb-0">{{ optional($ranking['road'] ?? null)->name ?? 'Belum ada' }}</div>
                </div>
                <div style="font-size: 3rem; color: #198754; opacity: 0.2;">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card h-100 border-0">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Nilai Tertinggi</div>
                    <div class="display-6 fw-bold" style="font-size: 1.5rem;">{{ isset($ranking['result']) ? number_format($ranking['result'], 4) : '-' }}</div>
                </div>
                <div style="font-size: 3rem; color: #ffc107; opacity: 0.2;">
                    <i class="bi bi-graph-up"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card h-100 border-0">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Terverifikasi</div>
                    <div class="display-6 fw-bold text-success">{{ $verifiedCount }}</div>
                </div>
                <div style="font-size: 3rem; color: #198754; opacity: 0.2;">
                    <i class="bi bi-check2-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card h-100 border-0">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small">Menunggu Verifikasi</div>
                    <div class="display-6 fw-bold text-warning">{{ $pendingCount }}</div>
                </div>
                <div style="font-size: 3rem; color: #ffc107; opacity: 0.2;">
                    <i class="bi bi-hourglass-split"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><i class="bi bi-trophy"></i> Top 3 Prioritas Perbaikan</h5>
                <span class="badge bg-light text-dark">MOORA</span>
            </div>
            <div class="card-body p-0">
                @forelse ($topThree as $row)
                    <div style="padding: 1.5rem; border-bottom: 1px solid #f0f0f0;" class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="badge bg-primary me-2">Rank {{ $row['rank'] }}</div>
                            <h6 class="mb-1">{{ $row['road']->name }}</h6>
                            <small class="text-muted">📍 {{ $row['road']->location }}</small>
                        </div>
                        <div class="text-end">
                            <div class="h5 fw-bold text-success">{{ number_format($row['result'], 4) }}</div>
                            <small class="text-muted">Nilai MOORA</small>
                        </div>
                    </div>
                @empty
                    <div style="padding: 2rem; text-align: center; color: #999;">
                        <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0">Belum ada data untuk ditampilkan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-shield-check"></i> Status Verifikasi Terbaru</h5>
            </div>
            <div class="card-body p-0">
                @forelse ($latestRoads as $road)
                    <div style="padding: 1rem 1.25rem; border-bottom: 1px solid #f0f0f0;" class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold">{{ $road->name }}</div>
                            <small class="text-muted">{{ $road->location }}</small>
                        </div>
                        @if ($road->is_verified)
                            <span class="badge bg-success">Terverifikasi</span>
                        @else
                            <span class="badge bg-warning text-dark">Menunggu</span>
                        @endif
                    </div>
                @empty
                    <div style="padding: 2rem; text-align: center; color: #999;">
                        <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0">Belum ada data ruas jalan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
