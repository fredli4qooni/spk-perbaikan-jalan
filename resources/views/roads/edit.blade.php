@extends('layouts.app')

@section('content')
@if (auth()->user()->role !== 'petugas')
    <div class="alert alert-warning">Hanya petugas yang dapat mengubah data ruas jalan.</div>
@else
<div class="page-header">
    <div class="page-title"><i class="bi bi-pencil-square"></i> Edit Ruas Jalan</div>
    <p class="page-subtitle">Perbarui detail ruas jalan sebelum diverifikasi.</p>
</div>

<div class="card form-shell">
    <div class="card-body guest-card-inner">
        <form method="POST" action="{{ route('roads.update', $road) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('roads.form')
            <div class="form-actions">
                <button class="btn btn-primary">Perbarui</button>
                <a href="{{ route('roads.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endif
@endsection
