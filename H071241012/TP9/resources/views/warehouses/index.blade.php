@extends('layouts.app') 
@section('content')
<div class="container">
    <h2>Manajemen Gudang (Warehouse)</h2>
    <a href="{{ route('warehouses.create') }}" class="btn btn-primary mb-3">Tambah Gudang</a>
    
    {{-- Tampilkan pesan success --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <table class="table">
        <thead>
            <tr>
                <th>Nama Gudang</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- Pastikan variabel $warehouses ada untuk perulangan --}}
            @foreach ($warehouses as $warehouse)
            <tr>
                <td>{{ $warehouse->name }}</td>
                <td>{{ $warehouse->location ?? '-' }}</td>
                <td>
                    <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('warehouses.destroy', $warehouse) }}" method="POST" style="display:inline;">
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