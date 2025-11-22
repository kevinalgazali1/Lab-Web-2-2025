@extends('layouts.app') 
@section('content')
<div class="container">
    <h2>{{ isset($warehouse) ? 'Edit Gudang: ' . $warehouse->name : 'Tambah Gudang Baru' }}</h2>
    
    <form action="{{ isset($warehouse) ? route('warehouses.update', $warehouse) : route('warehouses.store') }}" method="POST">
        @csrf
        @if(isset($warehouse))
            @method('PUT')
        @endif
        
        <div class="mb-3">
            <label for="name" class="form-label">Nama Gudang</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $warehouse->name ?? old('name') }}" required>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Lokasi Gudang</label>
            <textarea class="form-control" id="location" name="location">{{ $warehouse->location ?? old('location') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection