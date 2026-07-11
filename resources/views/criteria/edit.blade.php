@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
        <i class="bi bi-pencil-square text-brand-purple"></i> Edit Kriteria
    </h2>
    <p class="text-sm text-gray-500 mt-1">Perbarui detail kriteria untuk penilaian MOORA.</p>
</div>

<div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
    <div class="p-6 md:p-8">
        <form method="POST" action="{{ route('criteria.update', $criterion) }}">
            @csrf
            @method('PUT')
            @include('criteria.form')
            <div class="mt-8 flex justify-end gap-3 pt-5 border-t border-gray-100">
                <a href="{{ route('criteria.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-purple focus:ring-offset-2">Kembali</a>
                <button type="submit" class="inline-flex justify-center items-center rounded-md border border-transparent bg-brand-purple px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-brand-purple focus:ring-offset-2">
                    <i class="bi bi-save mr-2"></i> Perbarui
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
