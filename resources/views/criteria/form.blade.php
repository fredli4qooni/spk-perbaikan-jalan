@php
$labelClass = "block text-sm font-medium text-gray-700 mb-1";
$inputClass = "mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-purple focus:ring-brand-purple sm:text-sm p-2 border";
@endphp
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div>
        <label class="{{ $labelClass }}">Kode</label>
        <input type="text" name="code" class="{{ $inputClass }}" value="{{ old('code', $criterion->code ?? '') }}" required>
    </div>
    <div>
        <label class="{{ $labelClass }}">Nama Kriteria</label>
        <input type="text" name="name" class="{{ $inputClass }}" value="{{ old('name', $criterion->name ?? '') }}" required>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div>
        <label class="{{ $labelClass }}">Bobot</label>
        <input type="number" step="0.01" name="weight" class="{{ $inputClass }}" value="{{ old('weight', $criterion->weight ?? '') }}" required>
    </div>
    <div>
        <label class="{{ $labelClass }}">Tipe</label>
        <select name="type" class="{{ $inputClass }}" required>
            <option value="benefit" {{ old('type', $criterion->type ?? '') == 'benefit' ? 'selected' : '' }}>Benefit</option>
            <option value="cost" {{ old('type', $criterion->type ?? '') == 'cost' ? 'selected' : '' }}>Cost</option>
        </select>
    </div>
    <div>
        <label class="{{ $labelClass }}">Satuan (Opsional)</label>
        <input type="text" name="unit" class="{{ $inputClass }}" value="{{ old('unit', $criterion->unit ?? '') }}">
    </div>
</div>
