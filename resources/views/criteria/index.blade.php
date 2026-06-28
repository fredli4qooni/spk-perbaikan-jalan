@extends('layouts.app')

@section('content')
<div class="page-header d-flex justify-content-between align-items-start gap-3 flex-wrap">
    <div>
        <div class="page-title"><i class="bi bi-list-check"></i> Data Kriteria</div>
        <p class="page-subtitle">Kelola kriteria dan bobot penilaian.</p>
    </div>
    <a href="{{ route('criteria.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Kriteria
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th><i class="bi bi-tag"></i> Kode</th>
                    <th>Nama</th>
                    <th class="text-center">Bobot</th>
                    <th class="text-center">Tipe</th>
                    <th>Satuan</th>
                    <th class="text-end" style="width: 200px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($criteria as $criterion)
                    <tr>
                        <td><strong>{{ $criterion->code }}</strong></td>
                        <td>{{ $criterion->name }}</td>
                        <td class="text-center"><span class="badge bg-light text-dark">{{ $criterion->weight }}</span></td>
                        <td class="text-center">
                            <span class="badge bg-{{ $criterion->type === 'cost' ? 'danger' : 'success' }}">
                                {{ $criterion->type === 'cost' ? 'Cost' : 'Benefit' }}
                            </span>
                        </td>
                        <td><small class="text-muted">{{ $criterion->unit }}</small></td>
                        <td class="text-end d-flex gap-2 justify-content-end">
                            <a href="{{ route('criteria.edit', $criterion) }}" class="btn btn-sm btn-warning btn-outline">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form action="{{ route('criteria.destroy', $criterion) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger text-white border-danger">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4"><i class="bi bi-inbox"></i> Belum ada kriteria.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $criteria->links() }}</div>
@endsection
