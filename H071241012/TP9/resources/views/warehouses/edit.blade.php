@extends('layouts.app') 
@section('content')
<div class="container">
    <h2>Edit Gudang: {{ $warehouse->name }}</h2>
    
    <form action="{{ route('warehouses.update', $warehouse) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="name" class="form-label">Nama Gudang</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="{{ $warehouse->name ?? old('name') }}" required>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Lokasi Gudang</label>
            <textarea class="form-control" id="location" name="location">{{ $warehouse->location ?? old('location') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Perbarui</button>
        <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection