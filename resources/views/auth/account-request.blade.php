@extends('layouts.guest')

@section('guest-title', 'Ajukan akun petugas dengan alur yang rapi.')
@section('guest-description', 'Permohonan akun masuk ke daftar admin untuk ditinjau, disetujui, atau ditolak secara terstruktur.')

@section('guest-content')
<div class="guest-card-inner">
    <div class="page-header">
        <div class="auth-title"><i class="bi bi-person-plus"></i> Permohonan Akun Petugas</div>
        <p class="auth-subtitle mb-0">Isi data berikut untuk mengajukan akses petugas.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('account-request.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Catatan</label>
            <textarea name="notes" class="form-control" rows="4" placeholder="Tuliskan alasan pengajuan akun (opsional)">{{ old('notes') }}</textarea>
        </div>
        <div class="mb-4">
            <label class="form-label">Role yang diminta</label>
            <input type="text" class="form-control" value="petugas" disabled>
        </div>
        <button class="btn btn-primary w-100 py-2 fw-semibold">Kirim Permohonan</button>
    </form>

    <div class="section-intro mt-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <div class="fw-bold">Butuh akses lebih dulu?</div>
            <small class="text-muted">Kembali ke login jika akun sudah aktif.</small>
        </div>
        <a href="{{ route('login') }}" class="btn btn-outline-secondary">Login</a>
    </div>
</div>
@endsection