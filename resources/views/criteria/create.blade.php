@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title"><i class="bi bi-plus-circle"></i> Tambah Kriteria</div>
    <p class="page-subtitle">Buat kriteria baru untuk perhitungan MOORA.</p>
</div>

<div class="card form-shell">
    <div class="card-body guest-card-inner">
        <form method="POST" action="{{ route('criteria.store') }}">
            @csrf
            @include('criteria.form')
            <div class="form-actions">
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('criteria.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
