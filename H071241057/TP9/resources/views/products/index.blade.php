@extends('template.home')

@section('title', 'Manajemen Produk')

@section('content')
<div class="container">
    <h1>Manajemen Produk</h1>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>Daftar Produk</span>
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                + Tambah Produk Baru
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $key => $product)
                        <tr>
                            <td>{{ $products->firstItem() + $key }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? 'Tanpa Kategori' }}</td>
                            <td>Rp {{ number_format($product->price, 2, ',', '.') }}</td>
                            <td>
                                <a href="{{route('products.show', $product->id)}}" class="btn btn-info btn-sm">Show</a>
                                <a href="{{route('products.edit', $product->id)}}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{route('products.destroy', $product->id)}}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data produk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {!! $products->links() !!}
        </div>
    </div>
</div>
@endsection
