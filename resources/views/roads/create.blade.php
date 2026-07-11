@extends('layouts.app')

@section('content')
@if (auth()->user()->role !== 'petugas')
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-r-md">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="bi bi-exclamation-triangle text-yellow-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700 font-medium mt-0.5">
                    Hanya petugas yang dapat menambahkan data ruas jalan.
                </p>
            </div>
        </div>
    </div>
@else
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
        <i class="bi bi-plus-circle text-brand-purple"></i> Tambah Ruas Jalan
    </h2>
    <p class="text-sm text-gray-500 mt-1">Masukkan detail ruas jalan yang akan dianalisis.</p>
</div>

<div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
    <div class="p-6 md:p-8">
        <form method="POST" action="{{ route('roads.store') }}" enctype="multipart/form-data">
            @csrf
            @include('roads.form')
            <div class="mt-8 flex justify-end gap-3 pt-5 border-t border-gray-100">
                <a href="{{ route('roads.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-purple focus:ring-offset-2">Kembali</a>
                <button type="submit" class="inline-flex justify-center items-center rounded-md border border-transparent bg-brand-purple px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-brand-purple focus:ring-offset-2">
                    <i class="bi bi-save mr-2"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection
