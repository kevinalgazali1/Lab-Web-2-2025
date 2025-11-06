@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Detail Ikan: {{ $fish->name }}</h2>
        <a href="{{ route('fishes.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama:</strong><br> {{ $fish->name }}</p>
                    <p><strong>Rarity:</strong><br> {{ $fish->rarity }}</p>
                    <p><strong>Harga Jual per kg:</strong><br> {{ number_format($fish->sell_price_per_kg) }} Coins</p>
                    <p><strong>Peluang Tangkap:</strong><br> {{ $fish->catch_probability }}%</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Berat Minimum:</strong><br> {{ $fish->base_weight_min }} kg</p>
                    <p><strong>Berat Maksimum:</strong><br> {{ $fish->base_weight_max }} kg</p>
                    <p><strong>Waktu Dibuat:</strong><br> {{ $fish->created_at->format('d M Y, H:i') }}</p>
                    <p><strong>Terakhir Update:</strong><br> {{ $fish->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
            <hr>
            <p><strong>Deskripsi:</strong><br>
                {!! nl2br(e($fish->description ?? 'Tidak ada deskripsi.')) !!}
            </p>
            <hr>
            <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('fishes.destroy', $fish) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus ikan ini?');">
                    Hapus
                </button>
            </form>
        </div>
    </div>
@endsection