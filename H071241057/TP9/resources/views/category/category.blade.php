@extends('template.home')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="container">
    <h1>Manajemen Kategori</h1>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>Daftar Kategori</span>
            <a href="{{ route('category.create') }}" class="btn btn-primary btn-sm">
                + Tambah Kategori Baru
            </a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Kategori </th>
                        <th scope="col">Deskripsi </th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $key => $category)
                        <tr>
                            <td>{{ $categories->firstItem() + $key }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description ?? '-' }}</td>
                            <td>
                                <a href="{{ route('category.show', $category) }}" class="btn btn-info btn-sm">Show</a>

                                <a href="{{ route('category.edit', $category) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('category.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada data kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {!! $categories->links() !!}
        </div>
    </div>
</div>
@endsection
