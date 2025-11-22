<div class="mb-3">
    <label class="form-label fw-bold">Nama Ikan</label>
    <input type="text" name="name" class="form-control"
        value="{{ old('name', $fish->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Rarity</label>
    <select name="rarity" class="form-select" required>
        @foreach ($rarities as $r)
        <option value="{{ $r }}" {{ old('rarity', $fish->rarity ?? '') == $r ? 'selected' : '' }}>
            {{ $r }}
        </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Berat Minimum (Kg)</label>
    <input type="number" step="0.01" name="base_weight_min" class="form-control"
           value="{{ old('base_weight_min', $fish->base_weight_min ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Berat Maksimum (Kg)</label>
    <input type="number" step="0.01" name="base_weight_max" class="form-control"
           value="{{ old('base_weight_max', $fish->base_weight_max ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Harga Jual / kg</label>
    <input type="number" name="sell_price_per_kg" class="form-control"
           value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Peluang Tertangkap (%)</label>
    <input type="number" step="0.01" name="catch_probability" class="form-control"
           value="{{ old('catch_probability', $fish->catch_probability ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Deskripsi</label>
    <textarea name="description" class="form-control">{{ old('description', $fish->description ?? '') }}</textarea>
</div>
