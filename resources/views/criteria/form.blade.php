@php
$labelClass = "block text-xs sm:text-sm font-medium text-gray-700 mb-1.5";
$inputClass = "block w-full rounded-xl border border-gray-200 shadow-xs focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/20 text-sm py-2.5 px-3.5 bg-white transition-all";
$selectClass = "block w-full rounded-xl border border-gray-200 shadow-xs focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/20 text-sm py-2.5 px-3.5 bg-white transition-all cursor-pointer";
@endphp

<div class="space-y-4 sm:space-y-5">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="{{ $labelClass }}">
                Kode Kriteria <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                name="code" 
                class="{{ $inputClass }}" 
                placeholder="Contoh: C1"
                value="{{ old('code', $criterion->code ?? '') }}" 
                required
            >
        </div>
        <div class="sm:col-span-2">
            <label class="{{ $labelClass }}">
                Nama Kriteria <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                name="name" 
                class="{{ $inputClass }}" 
                placeholder="Contoh: Panjang Kerusakan Jalan"
                value="{{ old('name', $criterion->name ?? '') }}" 
                required
            >
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="{{ $labelClass }}">
                Bobot (%) <span class="text-red-500">*</span>
            </label>
            <input 
                type="number" 
                step="0.01" 
                name="weight" 
                class="{{ $inputClass }}" 
                placeholder="Contoh: 25"
                value="{{ old('weight', $criterion->weight ?? '') }}" 
                required
            >
        </div>
        <div>
            <label class="{{ $labelClass }}">
                Tipe Kriteria <span class="text-red-500">*</span>
            </label>
            <select name="type" class="{{ $selectClass }}" required>
                <option value="benefit" {{ old('type', $criterion->type ?? '') == 'benefit' ? 'selected' : '' }}>Benefit (Keuntungan)</option>
                <option value="cost" {{ old('type', $criterion->type ?? '') == 'cost' ? 'selected' : '' }}>Cost (Biaya)</option>
            </select>
        </div>
        <div>
            <label class="{{ $labelClass }}">
                Satuan (Opsional)
            </label>
            <input 
                type="text" 
                name="unit" 
                class="{{ $inputClass }}" 
                placeholder="Contoh: cm / kategori"
                value="{{ old('unit', $criterion->unit ?? '') }}"
            >
        </div>
    </div>
</div>
