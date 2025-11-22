@extends('layouts.app')

@section('content')
<h2 class="mb-4 fw-bold">➕ Tambah Ikan Baru</h2>

<form method="POST" action="{{ route('fishes.store') }}">
    @csrf
    @include('fishes.form')

    <button class="btn btn-modern btn-add mt-3">Simpan</button>
    <a href="{{ route('fishes.index') }}" class="btn btn-modern btn-detail mt-3">Kembali</a>
</form>
@endsection
