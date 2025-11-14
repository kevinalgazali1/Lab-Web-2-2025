@extends('template.home')

@section('title', 'Tambah Gudang Baru')

@section('content')
<div class="container">
    <h1>Tambah Gudang Baru</h1>
    <p>Form inputan meliputi nama gudang dan lokasi gudang.</p>

    <div class="card">
        <div class="card-header">
            Form Tambah Gudang
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

            <form action="{{route('warehouses.store')}}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Gudang</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Lokasi Gudang</label>
                    <textarea class="form-control" id="location" name="location" rows="3">{{ old('location') }}</textarea>
                </div>

                <a href="{{route('warehouses.index')}}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
