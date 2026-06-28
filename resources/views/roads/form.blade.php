<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label">Nama Ruas Jalan</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $road->name ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Lokasi</label>
        <input type="text" name="location" class="form-control" value="{{ old('location', $road->location ?? '') }}" required>
    </div>
</div>
<div class="row g-3 mb-3">
    <div class="col-md-4">
        <label class="form-label">Panjang Jalan (m)</label>
        <input type="number" step="0.01" name="length" class="form-control" value="{{ old('length', $road->length ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Lebar Jalan (m)</label>
        <input type="number" step="0.01" name="width" class="form-control" value="{{ old('width', $road->width ?? '') }}" required>
    </div>
    <div class="col-md-4">
        <label class="form-label">Banyaknya Lubang (buah)</label>
        <input type="number" name="holes_count" class="form-control" value="{{ old('holes_count', $road->holes_count ?? '') }}" required>
    </div>
</div>
<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label">Kedalaman Lubang (cm)</label>
        <input type="number" step="0.01" name="hole_depth" class="form-control" value="{{ old('hole_depth', $road->hole_depth ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Kepentingan Jalan</label>
        <select name="importance" class="form-select" required>
            <option value="" {{ old('importance', $road->importance ?? '') == '' ? 'selected' : '' }}>Pilih kepentingan</option>
            <option value="sekolah" {{ old('importance', $road->importance ?? '') == 'sekolah' ? 'selected' : '' }}>Sekolah</option>
            <option value="pasar" {{ old('importance', $road->importance ?? '') == 'pasar' ? 'selected' : '' }}>Pasar</option>
            <option value="kantor" {{ old('importance', $road->importance ?? '') == 'kantor' ? 'selected' : '' }}>Kantor</option>
            <option value="lainnya" {{ old('importance', $road->importance ?? '') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
        </select>
    </div>
</div>
<div class="row g-3 mb-3">
    <div class="col-md-4">
        <label class="form-label">Kecamatan</label>
        <select name="kecamatan" class="form-select" required>
            <option value="" {{ old('kecamatan', $road->kecamatan ?? '') == '' ? 'selected' : '' }}>Pilih Kecamatan</option>
            <option value="Kecamatan A" {{ old('kecamatan', $road->kecamatan ?? '') == 'Kecamatan A' ? 'selected' : '' }}>Kecamatan A</option>
            <option value="Kecamatan B" {{ old('kecamatan', $road->kecamatan ?? '') == 'Kecamatan B' ? 'selected' : '' }}>Kecamatan B</option>
            <option value="Kecamatan C" {{ old('kecamatan', $road->kecamatan ?? '') == 'Kecamatan C' ? 'selected' : '' }}>Kecamatan C</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Kelurahan</label>
        <select name="kelurahan" class="form-select" required>
            <option value="" {{ old('kelurahan', $road->kelurahan ?? '') == '' ? 'selected' : '' }}>Pilih Kelurahan</option>
            <option value="Kelurahan X" {{ old('kelurahan', $road->kelurahan ?? '') == 'Kelurahan X' ? 'selected' : '' }}>Kelurahan X</option>
            <option value="Kelurahan Y" {{ old('kelurahan', $road->kelurahan ?? '') == 'Kelurahan Y' ? 'selected' : '' }}>Kelurahan Y</option>
            <option value="Kelurahan Z" {{ old('kelurahan', $road->kelurahan ?? '') == 'Kelurahan Z' ? 'selected' : '' }}>Kelurahan Z</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">RT</label>
        <select name="rt" class="form-select" required>
            <option value="" {{ old('rt', $road->rt ?? '') == '' ? 'selected' : '' }}>Pilih RT</option>
            @for($i=1;$i<=10;$i++)
                <option value="{{ str_pad($i,2,'0',STR_PAD_LEFT) }}" {{ old('rt', $road->rt ?? '') == str_pad($i,2,'0',STR_PAD_LEFT) ? 'selected' : '' }}>RT {{ str_pad($i,2,'0',STR_PAD_LEFT) }}</option>
            @endfor
        </select>
    </div>
</div>
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <label class="form-label">Tahun Survei</label>
        <input type="number" name="survey_year" class="form-control" value="{{ old('survey_year', $road->survey_year ?? date('Y')) }}" required>
    </div>
    <div class="col-md-9">
        <label class="form-label">Foto</label>
        <input type="file" name="photo" class="form-control">
        @if (!empty($road?->photo))
            <small class="text-muted d-block mt-1">Foto saat ini: {{ $road->photo }}</small>
        @endif
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Catatan</label>
    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $road->notes ?? '') }}</textarea>
</div>
