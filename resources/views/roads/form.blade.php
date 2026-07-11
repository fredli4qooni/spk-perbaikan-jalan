@php
$labelClass = "block text-sm font-medium text-gray-700 mb-1";
$inputClass = "mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-purple focus:ring-brand-purple sm:text-sm p-2 border";
@endphp
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div>
        <label class="{{ $labelClass }}">Nama Ruas Jalan</label>
        <input type="text" name="name" class="{{ $inputClass }}" value="{{ old('name', $road->name ?? '') }}" required>
    </div>
    <div>
        <label class="{{ $labelClass }}">Lokasi</label>
        <input type="text" name="location" class="{{ $inputClass }}" value="{{ old('location', $road->location ?? '') }}" required>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div>
        <label class="{{ $labelClass }}">Panjang Jalan (m)</label>
        <input type="number" step="0.01" name="length" class="{{ $inputClass }}" value="{{ old('length', $road->length ?? '') }}" required>
    </div>
    <div>
        <label class="{{ $labelClass }}">Lebar Jalan (m)</label>
        <input type="number" step="0.01" name="width" class="{{ $inputClass }}" value="{{ old('width', $road->width ?? '') }}" required>
    </div>
    <div>
        <label class="{{ $labelClass }}">Banyaknya Lubang (buah)</label>
        <input type="number" name="holes_count" class="{{ $inputClass }}" value="{{ old('holes_count', $road->holes_count ?? '') }}" required>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div>
        <label class="{{ $labelClass }}">Kedalaman Lubang (cm)</label>
        <input type="number" step="0.01" name="hole_depth" class="{{ $inputClass }}" value="{{ old('hole_depth', $road->hole_depth ?? '') }}" required>
    </div>
    <div>
        <label class="{{ $labelClass }}">Kepentingan Jalan</label>
        <select name="importance" class="{{ $inputClass }}" required>
            <option value="" {{ old('importance', $road->importance ?? '') == '' ? 'selected' : '' }}>Pilih kepentingan</option>
            <option value="sekolah" {{ old('importance', $road->importance ?? '') == 'sekolah' ? 'selected' : '' }}>Sekolah</option>
            <option value="pasar" {{ old('importance', $road->importance ?? '') == 'pasar' ? 'selected' : '' }}>Pasar</option>
            <option value="kantor" {{ old('importance', $road->importance ?? '') == 'kantor' ? 'selected' : '' }}>Kantor</option>
            <option value="lainnya" {{ old('importance', $road->importance ?? '') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
        </select>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div>
        <label class="{{ $labelClass }}">Kecamatan</label>
        <select name="kecamatan" class="{{ $inputClass }}" required>
            <option value="" {{ old('kecamatan', $road->kecamatan ?? '') == '' ? 'selected' : '' }}>Pilih Kecamatan</option>
            <option value="Kecamatan A" {{ old('kecamatan', $road->kecamatan ?? '') == 'Kecamatan A' ? 'selected' : '' }}>Kecamatan A</option>
            <option value="Kecamatan B" {{ old('kecamatan', $road->kecamatan ?? '') == 'Kecamatan B' ? 'selected' : '' }}>Kecamatan B</option>
            <option value="Kecamatan C" {{ old('kecamatan', $road->kecamatan ?? '') == 'Kecamatan C' ? 'selected' : '' }}>Kecamatan C</option>
        </select>
    </div>
    <div>
        <label class="{{ $labelClass }}">Kelurahan</label>
        <select name="kelurahan" class="{{ $inputClass }}" required>
            <option value="" {{ old('kelurahan', $road->kelurahan ?? '') == '' ? 'selected' : '' }}>Pilih Kelurahan</option>
            <option value="Kelurahan X" {{ old('kelurahan', $road->kelurahan ?? '') == 'Kelurahan X' ? 'selected' : '' }}>Kelurahan X</option>
            <option value="Kelurahan Y" {{ old('kelurahan', $road->kelurahan ?? '') == 'Kelurahan Y' ? 'selected' : '' }}>Kelurahan Y</option>
            <option value="Kelurahan Z" {{ old('kelurahan', $road->kelurahan ?? '') == 'Kelurahan Z' ? 'selected' : '' }}>Kelurahan Z</option>
        </select>
    </div>
    <div>
        <label class="{{ $labelClass }}">RT</label>
        <select name="rt" class="{{ $inputClass }}" required>
            <option value="" {{ old('rt', $road->rt ?? '') == '' ? 'selected' : '' }}>Pilih RT</option>
            @for($i=1;$i<=10;$i++)
                <option value="{{ str_pad($i,2,'0',STR_PAD_LEFT) }}" {{ old('rt', $road->rt ?? '') == str_pad($i,2,'0',STR_PAD_LEFT) ? 'selected' : '' }}>RT {{ str_pad($i,2,'0',STR_PAD_LEFT) }}</option>
            @endfor
        </select>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-6">
    <div class="md:col-span-3">
        <label class="{{ $labelClass }}">Tahun Survei</label>
        <input type="number" name="survey_year" class="{{ $inputClass }}" value="{{ old('survey_year', $road->survey_year ?? date('Y')) }}" required>
    </div>
    <div class="md:col-span-4">
        <label class="{{ $labelClass }}">Foto</label>
        <input type="file" name="photo" class="{{ $inputClass }} file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-brand-purple/10 file:text-brand-purple hover:file:bg-brand-purple/20" accept="image/*">
        @if (!empty($road?->photo))
            <p class="text-xs text-gray-500 mt-2 flex items-center gap-1"><i class="bi bi-image"></i> Foto saat ini: {{ basename($road->photo) }}</p>
        @endif
    </div>
    <div class="md:col-span-5">
        <label class="{{ $labelClass }}">Video Dokumentasi (Opsional)</label>
        <input type="file" name="video" class="{{ $inputClass }} file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-brand-purple/10 file:text-brand-purple hover:file:bg-brand-purple/20" accept="video/mp4,video/quicktime,video/x-msvideo">
        @if (!empty($road?->video))
            <p class="text-xs text-gray-500 mt-2 flex items-center gap-1"><i class="bi bi-film"></i> Video saat ini: {{ basename($road->video) }}</p>
        @endif
    </div>
</div>

<div class="mb-6">
    <label class="{{ $labelClass }}">Catatan</label>
    <textarea name="notes" class="{{ $inputClass }}" rows="3">{{ old('notes', $road->notes ?? '') }}</textarea>
</div>
