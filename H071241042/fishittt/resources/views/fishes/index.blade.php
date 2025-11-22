@extends('layouts.app')

@section('content')
<h2 class="mb-4 fw-bold">Daftar Ikan</h2>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="GET" class="mb-4 d-flex gap-2">
    <select name="rarity" class="form-select w-auto">
        <option value="">Filter Rarity</option>
        @foreach (['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'] as $r)
            <option value="{{ $r }}" {{ ($rarity == $r) ? 'selected' : '' }}>{{ $r }}</option>
        @endforeach
    </select>
    <button class="btn btn-modern btn-detail">Filter</button>
</form>

<a href="{{ route('fishes.create') }}" class="btn btn-modern btn-add mb-3">+ Tambah Ikan</a>

<table class="table table-hover shadow-sm">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Rarity</th>
            <th>Berat</th>
            <th>Harga/kg</th>
            <th>Peluang (%)</th>
            <th class="text-center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($fishes as $fish)
        <tr>
            <td>{{ $fish->name }}</td>
            <td>{{ $fish->rarity }}</td>
            <td>{{ $fish->base_weight_min }}–{{ $fish->base_weight_max }} kg</td>
            <td>{{ $fish->sell_price_per_kg }}</td>
            <td>{{ $fish->catch_probability }}%</td>
            <td class="text-center">
                <a href="{{ route('fishes.show', $fish) }}" class="btn btn-modern btn-detail btn-sm">Detail</a>
                <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-modern btn-edit btn-sm">Edit</a>
                <form action="{{ route('fishes.destroy', $fish) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-modern btn-delete btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $fishes->links() }}
@endsection
