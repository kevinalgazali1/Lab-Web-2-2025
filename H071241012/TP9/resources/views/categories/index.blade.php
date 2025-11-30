@extends('layouts.app') 
@section('content')
<div class="container">
    <h2>Manajemen Kategori Produk</h2>

    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description ?? '-' }}</td>
                <td>
                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">Edit</a>
                    {{-- Form Hapus --}}
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection