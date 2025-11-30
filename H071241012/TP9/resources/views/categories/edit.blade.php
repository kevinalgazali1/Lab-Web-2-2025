@extends('layouts.app') 
@section('content')
<div class="container">
    <h2>Edit Kategori: {{ $category->name }}</h2>
    
    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT') 
        
        <div class="mb-3">
            <label for="name" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="{{ $category->name ?? old('name') }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description">{{ $category->description ?? old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Perbarui</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection