@extends('template.home')

@section('title', 'Manajemen Stok')

@section('content')
<div class="container">
    <h1>Manajemen Stok</h1>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>Daftar Stok Produk</span>
            <a href="{{route('stocks.transfer') }}" class="btn btn-success btn-sm">
                Transfer Stok Masuk/Keluar
            </a>
        </div>
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="GET" action="{{ route('stocks.index') }}" class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <label for="warehouse_id" class="form-label">Filter per Gudang</label>
                        <select name="warehouse_id" id="warehouse_id" class="form-select">
                            <option value="">-- Tampilkan Semua Gudang --</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Gudang</th>
                        <th scope="col">Total Stok</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Asumsi $stocks (dari tabel product_warehouses) dikirim dari controller --}}
                    @forelse ($stocks as $stock)
                        <tr>
                            <td>{{ $stock->product->name }}</td>
                            <td>{{ $stock->warehouse->name }}</td>
                            <td><strong>{{ $stock->quantity }}</strong> unit</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada data stok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination (jika datanya banyak) --}}
            {!! $stocks->appends(request()->query())->links() !!}
        </div>
    </div>
</div>
@endsection
