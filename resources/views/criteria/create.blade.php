@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto pb-12">
    <!-- Header Halaman (Rata Kiri Presisi) -->
    <div class="mb-5 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('criteria.index') }}" class="w-10 h-10 rounded-xl bg-white border border-gray-200 text-gray-600 flex items-center justify-center hover:bg-gray-50 hover:text-brand-purple transition-all shadow-xs" title="Kembali ke Daftar">
                <i class="bi bi-arrow-left text-lg"></i>
            </a>
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-gray-900 leading-tight">
                    Tambah Kriteria
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Tambahkan kriteria baru untuk penilaian metode MOORA.</p>
            </div>
        </div>
    </div>

    <!-- Main Card Container -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <form method="POST" action="{{ route('criteria.store') }}">
            @csrf
            <div class="p-5 sm:p-7 md:p-8">
                @include('criteria.form')
            </div>

            <!-- Footer Action Bar -->
            <div class="px-5 py-4 sm:px-8 sm:py-5 bg-gray-50/80 border-t border-gray-200/80 flex items-center justify-end gap-3">
                <a 
                    href="{{ route('criteria.index') }}" 
                    class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-xs hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all"
                >
                    Batal
                </a>
                <button 
                    type="submit" 
                    class="inline-flex items-center justify-center rounded-xl border border-transparent bg-brand-purple px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-brand-purple-hover focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all"
                >
                    <i class="bi bi-save mr-2"></i> Simpan Kriteria
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
