@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title"><i class="bi bi-pencil-square"></i> Edit Kriteria</div>
    <p class="page-subtitle">Perbarui data kriteria agar perhitungan tetap konsisten.</p>
</div>

<div class="card form-shell">
    <div class="card-body guest-card-inner">
        <form method="POST" action="{{ route('criteria.update', $criterion) }}">
            @csrf
            @method('PUT')
            @include('criteria.form')
            <div class="form-actions">
                <button class="btn btn-primary">Perbarui</button>
                <a href="{{ route('criteria.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
