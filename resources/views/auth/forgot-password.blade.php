@extends('layouts.guest')

@section('guest-title', 'Reset password dengan alur yang jelas.')
@section('guest-description', 'Perbarui password akun admin atau petugas tanpa meninggalkan tampilan yang seragam dengan halaman login.')

@section('guest-content')
<div class="guest-card-inner">
    <div class="page-header">
        <div class="auth-title"><i class="bi bi-key"></i> Lupa Password</div>
        <p class="auth-subtitle mb-0">Masukkan email akun lalu tentukan password baru.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100 py-2 fw-semibold">Perbarui Password</button>
    </form>

    <div class="section-intro mt-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <div class="fw-bold">Kembali ke login</div>
            <small class="text-muted">Setelah password diperbarui, silakan masuk lagi.</small>
        </div>
        <a href="{{ route('login') }}" class="btn btn-outline-secondary">Login</a>
    </div>
</div>
@endsection