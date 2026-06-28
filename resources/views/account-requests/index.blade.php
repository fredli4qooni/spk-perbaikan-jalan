@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title"><i class="bi bi-shield-check"></i> Verifikasi Petugas</div>
    <p class="page-subtitle">Daftar permohonan akun petugas yang menunggu verifikasi admin.</p>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th class="text-center">Tanggal</th>
                    <th>Diproses Oleh</th>
                    <th>Diproses Pada</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $request)
                    <tr>
                        <td><strong>{{ $request->name }}</strong></td>
                        <td>{{ $request->email }}</td>
                        <td><span class="badge bg-secondary">{{ $request->requested_role }}</span></td>
                        <td>
                            @if ($request->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif ($request->status === 'approved')
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>{{ $request->notes ?: '-' }}</td>
                        <td class="text-center text-muted">{{ $request->created_at?->format('d-m-Y H:i') }}</td>
                        <td>{{ $request->processedBy?->name ?: '-' }}</td>
                        <td>{{ $request->processed_at?->format('d-m-Y H:i') ?: '-' }}</td>
                        <td class="text-center">
                            @if ($request->status === 'pending')
                                <form action="{{ route('account-requests.approve', $request->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success" onclick="return confirm('Setuju membuat akun untuk {{ $request->email }}?')">Setujui</button>
                                </form>
                                <form action="{{ route('account-requests.deny', $request->id) }}" method="POST" class="d-inline ms-1">
                                    @csrf
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Tolak permohonan ini?')">Tolak</button>
                                </form>
                            @elseif ($request->status === 'approved')
                                <form action="{{ route('account-requests.resend', $request->id) }}" method="POST" class="d-inline ms-1">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-primary" onclick="return confirm('Kirim ulang email kredensial ke {{ $request->email }}?')">Kirim Ulang</button>
                                </form>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">Belum ada permohonan akun.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $requests->links() }}</div>
@endsection