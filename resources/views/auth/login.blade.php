@extends('layouts.guest')

@section('guest-title', 'Prioritas perbaikan jalan yang lebih cepat, rapi, dan terukur.')
@section('guest-description', 'Masuk sebagai admin atau petugas untuk mengelola data jalan, verifikasi, dan hasil MOORA dalam satu sistem.')

@section('guest-content')
<div class="guest-card-inner">
    <div class="page-header">
        <div class="auth-title"><i class="bi bi-diagram-3"></i> Masuk ke Sistem</div>
        <p class="auth-subtitle mb-0">Gunakan akun admin atau petugas untuk mengakses fitur sesuai role.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong><i class="bi bi-exclamation-circle"></i> Gagal!</strong> Email atau password salah.
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            <strong><i class="bi bi-check-circle"></i> Berhasil!</strong> {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-envelope"></i> Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="admin@pupr.test" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="bi bi-lock"></i> Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3 gap-3 flex-wrap">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>
            <a href="{{ route('password.request') }}" class="small text-decoration-none">Lupa password?</a>
        </div>
        <button class="btn btn-primary w-100 py-2 fw-semibold">Masuk</button>
    </form>

    <div class="row g-2 mt-3">
        <div class="col-12">
            <a href="{{ route('account-request.create') }}" class="btn btn-outline-secondary w-100 py-2"><i class="bi bi-person-plus"></i> Permohonan Akun</a>
        </div>
    </div>

    <div class="section-intro mt-3">
        <div class="fw-bold mb-1">Akun demo</div>
        <div>Admin: <strong>admin@pupr.test</strong> / <strong>password</strong></div>
        <div>Petugas: <strong>petugas@pupr.test</strong> / <strong>password</strong></div>
    </div>
</div>
@endsection