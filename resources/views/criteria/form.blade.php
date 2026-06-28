<div class="row g-3 mb-3">
    <div class="col-md-3">
        <label class="form-label">Kode</label>
        <input type="text" name="code" class="form-control" value="{{ old('code', $criterion->code ?? '') }}" required>
    </div>
    <div class="col-md-5">
        <label class="form-label">Nama Kriteria</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $criterion->name ?? '') }}" required>
    </div>
    <div class="col-md-2">
        <label class="form-label">Bobot</label>
        <input type="number" step="0.01" name="weight" class="form-control" value="{{ old('weight', $criterion->weight ?? 0) }}" required>
    </div>
    <div class="col-md-2">
        <label class="form-label">Tipe</label>
        <select name="type" class="form-select" required>
            <option value="benefit" @selected(old('type', $criterion->type ?? 'benefit') === 'benefit')>Benefit</option>
            <option value="cost" @selected(old('type', $criterion->type ?? '') === 'cost')>Cost</option>
        </select>
    </div>
</div>
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <label class="form-label">Satuan</label>
        <input type="text" name="unit" class="form-control" value="{{ old('unit', $criterion->unit ?? '') }}" required>
    </div>
    <div class="col-md-9">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="2" required>{{ old('description', $criterion->description ?? '') }}</textarea>
    </div>
</div>
