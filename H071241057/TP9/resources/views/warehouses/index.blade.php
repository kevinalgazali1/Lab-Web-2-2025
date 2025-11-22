@extends('template.home')

@section('title', 'Manajemen Gudang')

@section('content')
<div class="container">
    <h1>Manajemen Gudang</h1>
    <p>Menampilkan list Gudang.</p>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <span>Daftar Gudang</span>
            <a href="{{ route('warehouses.create') }}" class="btn btn-primary btn-sm">
                + Tambah Gudang Baru
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
                        <th scope="col">Nama Gudang </th>
                        <th scope="col">Deskripsi </th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($warehouses as $key => $warehouse)
                        <tr>
                            <td>{{ $warehouses->firstItem() + $key }}</td>
                            <td>{{ $warehouse->name }}</td>
                            <td>{{ $warehouse->location ?? '-' }}</td>
                            <td>
                                <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('warehouses.destroy', $warehouse) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
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

            {!! $warehouses->links() !!}
        </div>
    </div>
</div>
@endsection
