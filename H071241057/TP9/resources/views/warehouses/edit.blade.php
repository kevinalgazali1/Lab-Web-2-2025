@extends('template.home')

@section('title', 'Edit Gudang')

@section('content')
<div class="container">
    <h1>Edit Gudang: {{ $warehouse->name }}</h1>

    <div class="card">
        <div class="card-header">
            Form Edit Gudang
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error!</strong> Terdapat masalah dengan inputan Anda:<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('warehouses.update', $warehouse) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Gudang</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $warehouse->name) }}" required>
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Lokasi (Opsional)</label>
                    <textarea class="form-control" id="location" name="location" rows="3">{{ old('location', $warehouse->location) }}</textarea>
                </div>

                <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
