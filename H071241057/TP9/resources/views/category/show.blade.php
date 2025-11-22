@extends('template.home')

@section('title', 'Detail Kategori')

@section('content')
<div class="container">
    <h1>Detail Kategori: {{ $category->name }}</h1>

    <div class="card">
        <div class="card-header">
            Detail
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Kategori:</label>
                <p>{{ $category->name }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi:</label>
                <p>{{ $category->description ?? 'Tidak ada deskripsi' }}</p>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Dibuat Pada:</label>
                <p>{{ $category->created_at?->format('d M Y, H:i') }}</p>
            </div>

            <a href="/category" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
