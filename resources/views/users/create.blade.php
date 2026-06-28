@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title"><i class="bi bi-person-plus"></i> Tambah Petugas</div>
    <p class="page-subtitle">Admin hanya dapat menambahkan user dengan role petugas.</p>
</div>

<div class="card form-shell">
    <div class="card-body guest-card-inner">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Role</label>
                    <input type="text" class="form-control" value="petugas" disabled>
                    <div class="form-text">Role akan disimpan sebagai petugas.</div>
                </div>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection