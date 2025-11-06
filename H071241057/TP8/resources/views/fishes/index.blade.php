@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Ikan</h2>
        <a href="{{ route('fishes.create') }}" class="btn btn-primary">Tambah Ikan Baru</a>
    </div>

    <form method="GET" action="{{ route('fishes.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-3">
                <select name="rarity" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Rarity</option>
                    @foreach ($rarities as $rarity)
                        <option value="{{ $rarity }}" {{ request('rarity') == $rarity ? 'selected' : '' }}>
                            {{ $rarity }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Rarity</th>
                    <th>Harga/kg (Coins)</th>
                    <th>Probabilitas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fishes as $index => $fish)
                    <tr>
                        <td>{{ $fishes->firstItem() + $index }}</td> 
                        <td>{{ $fish->name }}</td>
                        <td>{{ $fish->rarity }}</td>
                        <td>{{ number_format($fish->sell_price_per_kg) }}</td>
                        <td>{{ $fish->catch_probability }}%</td>
                        <td>
                            <a href="{{ route('fishes.show', $fish) }}" class="btn btn-info btn-sm">Lihat</a>
                            <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('fishes.destroy', $fish) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus ikan ini?');"> 
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Data ikan tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $fishes->links() }}
    </div>
@endsection