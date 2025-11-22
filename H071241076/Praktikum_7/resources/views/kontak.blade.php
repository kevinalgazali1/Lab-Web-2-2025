@extends('layouts.master')

@section('title', 'Kontak')

@section('content')

<div class="py-12">
    <h1 class="text-4xl font-bold text-brand-dark text-center mb-12">
        Hubungi Kami
    </h1>

    <div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <p class="text-center text-gray-700 mb-6">
            Punya pertanyaan atau masukan? Silakan isi form di bawah ini.
        </p>

        <form action="#" method="POST">

            <div class="mb-4">
                <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                <input type="text" id="nama" name="nama"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-dark"
                    placeholder="John Doe">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Alamat Email</label>
                <input type="email" id="email" name="email"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-dark"
                    placeholder="john.doe@example.com">
            </div>

            <div class="mb-6">
                <label for="pesan" class="block text-gray-700 font-medium mb-2">Pesan Anda</label>
                <textarea id="pesan" name="pesan" rows="5"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-dark"
                    placeholder="Tuliskan pesan Anda di sini..."></textarea>
            </div>

            <div class="text-center">
                <button type="submit"
                    class="bg-brand-dark text-white font-bold px-6 py-3 rounded-lg
                                   hover:bg-opacity-90 transition-colors duration-200">
                    Kirim Pesan
                </button>
            </div>

        </form>
    </div>
</div>

@endsection