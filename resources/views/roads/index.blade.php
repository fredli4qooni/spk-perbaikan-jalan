@extends('layouts.app')

@section('content')
<div class="page-header d-flex justify-content-between align-items-start gap-3 flex-wrap">
    <div>
        <div class="page-title"><i class="bi bi-road-lane"></i> Data Ruas Jalan</div>
        <p class="page-subtitle">Kelola data ruas jalan yang akan dianalisis.</p>
    </div>
    @if (auth()->user()->role === 'petugas')
        <a href="{{ route('roads.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Ruas Jalan
        </a>
    @endif
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th><i class="bi bi-file-text"></i> Nama Ruas</th>
                    <th><i class="bi bi-geo-alt"></i> Lokasi</th>
                    <th class="text-center">Tahun</th>
                    <th class="text-center">Foto</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Nilai</th>
                    <th class="text-end" style="width: 200px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roads as $road)
                    <tr>
                        <td><strong>{{ $road->name }}</strong></td>
                        <td>{{ $road->location }}</td>
                        <td class="text-center"><span class="badge bg-info">{{ $road->survey_year }}</span></td>
                        <td class="text-center">
                            @if ($road->photo)
                                <img src="{{ asset('storage/' . $road->photo) }}" alt="foto" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#photoModal{{ $road->id }}">
                                <div class="modal fade" id="photoModal{{ $road->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <img src="{{ asset('storage/' . $road->photo) }}" alt="foto" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($road->is_verified)
                                <span class="badge bg-success">Terverifikasi</span>
                            @else
                                <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                            @endif
                        </td>
                        <td class="text-center"><span class="badge bg-secondary">{{ $road->scores_count }}</span></td>
                        <td class="text-end action-cell">
                            @if (auth()->user()->role === 'petugas')
                                <div class="d-inline-flex gap-2 align-items-center justify-content-end">
                                    <a href="{{ route('roads.edit', $road) }}" class="btn btn-sm btn-warning btn-outline">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('roads.destroy', $road) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-outline">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                    </form>
                                </div>
                            @else
                                @if (! $road->is_verified)
                                    <div class="d-inline-flex gap-2 align-items-center justify-content-end">
                                        <form action="{{ route('roads.verify', $road) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success btn-outline" onclick="return confirm('Verifikasi data ruas jalan ini?')">
                                                <i class="bi bi-check-circle"></i> Verifikasi
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted small">Diverifikasi {{ $road->verified_at?->format('d-m-Y H:i') }}</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4"><i class="bi bi-inbox"></i> Belum ada data ruas jalan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $roads->links() }}</div>

{{-- styles moved to public/css/app.css for easier maintenance --}}
@endsection
