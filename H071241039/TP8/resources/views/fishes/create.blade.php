@extends('layouts.app')

@section('title','Tambah Ikan')

@section('content')
<h3>Tambah Ikan Baru</h3>

<form action="{{ route('fishes.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Nama Ikan</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label>Rarity</label>
        <select name="rarity" class="form-select">
            @foreach($rarities as $r)
                <option value="{{ $r }}" {{ old('rarity')==$r?'selected':'' }}>{{ $r }}</option>
            @endforeach
        </select>
        @error('rarity')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Berat Minimum (kg)</label>
            <input type="number" step="0.01" name="base_weight_min" class="form-control" min="0.1" required>
            @error('base_weight_min')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="col-md-6 mb-3">
            <label>Berat Maksimum (kg)</label>
            <input type="number" step="0.01" name="base_weight_max" class="form-control" min="0.1" required>
            @error('base_weight_max')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
    </div>

    <div class="mb-3">
        <label>Harga Jual per Kg (Coins)</label>
        <input type="number" name="sell_price_per_kg" class="form-control" value="{{ old('sell_price_per_kg') }}">
        @error('sell_price_per_kg')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label>Catch Probability (%)</label>
        <input type="number" step="0.01" name="catch_probability" class="form-control" min="0.01" max="100" required>
        @error('catch_probability')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        @error('description')<small class="text-danger">{{ $message }}</small>@enderror
    </div>

    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('fishes.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
