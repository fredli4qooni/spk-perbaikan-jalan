@extends('layouts.app')

@section('content')
@if (auth()->user()->role !== 'petugas')
    <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-6 rounded-r-xl shadow-xs">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="bi bi-exclamation-triangle text-amber-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-amber-800 font-semibold mt-0.5">
                    Hanya petugas yang dapat mengubah data ruas jalan.
                </p>
            </div>
        </div>
    </div>
@else
<div class="max-w-5xl mx-auto pb-12 sm:pb-8">
    <!-- Header Halaman (Rata Kiri Presisi) -->
    <div class="mb-5 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('roads.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-200 text-gray-600 flex items-center justify-center hover:bg-gray-50 hover:text-brand-purple transition-all shadow-xs" title="Kembali ke Daftar">
                <i class="bi bi-arrow-left text-lg"></i>
            </a>
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">
                    Edit Ruas Jalan
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Perbarui detail ruas jalan sebelum dianalisis.</p>
            </div>
        </div>
    </div>

    <!-- Main Card Form Multi-Step Container -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <form method="POST" action="{{ route('roads.update', $road) }}" enctype="multipart/form-data" id="roadMainForm" novalidate>
            @csrf
            @method('PUT')
            <div class="p-5 sm:p-7 md:p-8">
                @include('roads.form')
            </div>
        </form>
    </div>
</div>
@endif
@endsection
