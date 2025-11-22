@extends('layouts.app')

@section('content')
<h2 class="mb-4 fw-bold">Edit Ikan</h2>

<form method="POST" action="{{ route('fishes.update', $fish) }}">
    @csrf
    @method('PUT')

    @include('fishes.form')

    <button class="btn btn-modern btn-edit mt-3">Update</button>
    <a href="{{ route('fishes.index') }}" class="btn btn-modern btn-detail mt-3">Kembali</a>
</form>
@endsection
