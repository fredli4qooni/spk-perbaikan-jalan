@extends('layouts.app')

@section('content')
@if (auth()->user()->role !== 'petugas')
    <div class="alert alert-warning">Hanya petugas yang dapat menambahkan data ruas jalan.</div>
@else
<div class="page-header">
    <div class="page-title"><i class="bi bi-plus-circle"></i> Tambah Ruas Jalan</div>
    <p class="page-subtitle">Masukkan detail ruas jalan yang akan dianalisis.</p>
</div>

<div class="card form-shell">
    <div class="card-body guest-card-inner">
        <form method="POST" action="{{ route('roads.store') }}" enctype="multipart/form-data">
            @csrf
            @include('roads.form')
            <div class="form-actions">
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('roads.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endif
@endsection
