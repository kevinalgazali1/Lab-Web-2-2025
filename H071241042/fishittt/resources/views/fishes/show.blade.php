@extends('layouts.app')

@section('content')
<h2 class="mb-4 fw-bold">Detail Ikan</h2>

<ul class="list-group shadow-sm">
    <li class="list-group-item"><strong>Nama:</strong> {{ $fish->name }}</li>
    <li class="list-group-item"><strong>Rarity:</strong> {{ $fish->rarity }}</li>
    <li class="list-group-item"><strong>Berat:</strong> {{ $fish->base_weight_min }} - {{ $fish->base_weight_max }} kg</li>
    <li class="list-group-item"><strong>Harga/kg:</strong> {{ $fish->sell_price_per_kg }}</li>
    <li class="list-group-item"><strong>Peluang:</strong> {{ $fish->catch_probability }}%</li>
    <li class="list-group-item"><strong>Deskripsi:</strong> {{ $fish->description }}</li>
</ul>

<a href="{{ route('fishes.edit', $fish) }}" class="btn btn-modern btn-edit mt-3">Edit</a>
<form action="{{ route('fishes.destroy', $fish) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button class="btn btn-modern btn-delete mt-3" onclick="return confirm('Hapus data ini?')">Hapus</button>
</form>
<a href="{{ route('fishes.index') }}" class="btn btn-modern btn-detail mt-3">Kembali</a>
@endsection
