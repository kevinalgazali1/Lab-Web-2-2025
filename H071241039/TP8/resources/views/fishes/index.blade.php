@extends('layouts.app')

@section('title', 'Daftar Ikan')

@section('content')
<style>
    /* 💜 Tema Lavender & Soft Pink */
    body {
        position: relative;
        min-height: 100vh;
        margin: 0;
        font-family: 'Poppins', sans-serif;
        color: #3f2f4f;
    }

    /* 🌸 Background dreamy lembut */
    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background:
            linear-gradient(rgba(230, 200, 255, 0.45), rgba(255, 210, 235, 0.5)),
            url("{{ asset('image/ikan.jpg') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: -1;
        filter: brightness(0.95);
    }

    /* 💎 Kartu tabel */
    .card {
        background: rgba(255, 255, 255, 0.85);
        border: none;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(210, 180, 255, 0.25);
    }

    /* 🌷 Form filter dengan warna pastel */
    form.row {
        background: linear-gradient(135deg, rgba(250, 230, 255, 0.9), rgba(255, 235, 245, 0.9));
        padding: 12px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(180, 140, 255, 0.15);
    }

    /* 🌸 Tombol utama dengan lavender pink */
    .btn-primary {
        background: linear-gradient(90deg, #c6a3ff, #f6a6d8);
        border: none;
        color: white;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background: linear-gradient(90deg, #b692ff, #f395ce);
        transform: scale(1.03);
    }

    .btn-secondary {
        background: #f7f3f9;
        border: 1px solid #ddd0f3;
        color: #6a5880;
    }

    .btn-info {
        background-color: #d1b3ff;
        border: none;
        color: #fff;
    }

    .btn-warning {
        background-color: #ffe0b2;
        border: none;
        color: #5a4200;
    }

    .btn-danger {
        background-color: #ffb0c6;
        border: none;
        color: white;
    }

    /* 🌼 Tabel */
    .table {
        border-radius: 10px;
        overflow: hidden;
    }

    thead.table-light {
        background: linear-gradient(90deg, #f1e3ff, #ffe8f5);
        color: #4a3a5f;
        font-weight: 600;
    }

    tbody tr:hover {
        background-color: rgba(245, 220, 255, 0.5);
        transition: background 0.3s;
    }

    /* 📱 Responsif */
    @media (max-width: 768px) {
        .container {
            padding: 15px;
        }
        form.row {
            flex-direction: column;
        }
    }
</style>

<div class="container mt-4">

    <form method="GET" class="row g-2 mb-3 align-items-end">
        <!-- Search by name -->
        <div class="col-md-3">
            <input id="search" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Cari nama...">
        </div>

        <!-- Filter by rarity -->
        <div class="col-md-2">
            <select id="rarity" name="rarity" class="form-select form-select-sm">
                @foreach($rarities as $key => $label)
                    <option value="{{ $key }}" {{ request('rarity') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <!-- Sort by -->
        <div class="col-md-3">
            <select id="sort_by" name="sort_by" class="form-select form-select-sm">
                <option value="" {{ empty(request('sort_by')) ? 'selected' : '' }}>Urutkan berdasarkan</option>
                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nama</option>
                <option value="sell_price_per_kg" {{ request('sort_by') == 'sell_price_per_kg' ? 'selected' : '' }}>Harga</option>
                <option value="catch_probability" {{ request('sort_by') == 'catch_probability' ? 'selected' : '' }}>Peluang %</option>
            </select>
        </div>

        <!-- Sort direction -->
        <div class="col-md-2">
            <select id="sort_dir" name="sort_dir" class="form-select form-select-sm">
                <option value="desc" {{ request('sort_dir') == 'desc' ? 'selected' : '' }}>Menurun</option>
                <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Menaik</option>
            </select>
        </div>

        <!-- Tombol -->
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-sm flex-grow-1">Terapkan</button>
            <a href="{{ route('fishes.index') }}" class="btn btn-secondary btn-sm flex-grow-1">Refresh</a>
        </div>
    </form>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Rarity</th>
                            <th>Berat (kg)</th>
                            <th>Harga /kg</th>
                            <th>Peluang %</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fishes as $fish)
                            <tr>
                                <td>{{ $fish->id }}</td>
                                <td>{{ $fish->name }}</td>
                                <td>{{ $fish->rarity }}</td>
                                <td>{{ $fish->weight_range }}</td>
                                <td>{{ $fish->formatted_price }}</td>
                                <td>{{ number_format($fish->catch_probability, 2) }}%</td>
                                <td>
                                    <a href="{{ route('fishes.show', $fish) }}" class="btn btn-sm btn-info">Lihat</a>
                                    <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('fishes.destroy', $fish) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus ikan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada ikan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $fishes->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
