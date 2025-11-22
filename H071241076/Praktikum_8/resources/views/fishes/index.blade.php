@extends('layouts.app')

@section('title', 'Daftar Ikan - Fish It')

@section('content')

    <div class="relative h-64 md:h-80 rounded-lg overflow-hidden mb-8 shadow-lg">
        <img src="https://i.pinimg.com/1200x/11/b5/be/11b5be481fbf16ced7b627b0a88708f4.jpg" 
             class="absolute inset-0 w-full h-full object-cover" alt="Underwater fishing">
        <div class="absolute inset-0 bg-black opacity-60"></div>
        <div class="relative h-full flex flex-col justify-center items-center text-center p-4">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-2" style="font-family: serif;">
                Fish It Database
            </h1>
        </div>
    </div>

    <div class="p-6 rounded-lg shadow-md" 
         style="background-color: rgba(31, 41, 55, 0.9);">

        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-100">Daftar Database Ikan</h2>
            <a href="{{ route('fishes.create') }}" 
               class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                + Tambah Ikan Baru
            </a>
        </div>

        <p class="text-gray-300 mb-6">Filter ikan yang ada di dalam game.</p>

        <div class="p-4 rounded-lg shadow-inner mb-6" 
             style="background-color: rgba(55, 65, 81, 0.9);">
            <form method="GET" action="{{ route('fishes.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                    <div classclass="md:col-span-1">
                        <label for="rarity" class="block text-sm font-medium text-gray-200">Filter Rarity</label>
                    </div>
                    <div class="md:col-span-2">
                        <select name="rarity" id="rarity" 
                                class="block w-full mt-1 rounded-md border-gray-600 bg-gray-900 text-gray-200 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                onchange="this.form.submit()">
                            <option value="">Semua Rarity</option>
                            @foreach($rarities as $rarity)
                                <option value="{{ $rarity }}" {{ request('rarity') == $rarity ? 'selected' : '' }}>
                                    {{ $rarity }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-1">
                        <a href="{{ route('fishes.index') }}" 
                           class="inline-block w-full text-center px-4 py-2 bg-gray-500 text-white rounded-lg shadow hover:bg-gray-600 transition duration-300">
                            Refresh
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="rounded-lg shadow-md overflow-hidden -mx-6 -mb-6" 
             style="background-color: rgba(31, 41, 55, 0.9);">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nama Ikan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Rarity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Harga Jual (per kg)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Peluang Tangkap (%)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700"> 
                        @forelse($fishes as $fish)
                            <tr class="hover:bg-gray-700/50 transition duration-150"> 
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-200">{{ $fish->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-100">{{ $fish->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-block px-4 py-1 text-sm font-medium
                                        @switch($fish->rarity)
                                            @case('Common') text-gray-300 border border-gray-500 @break
                                            @case('Uncommon') text-green-400 border border-green-500 rounded-lg @break
                                            @case('Rare') text-blue-300 border border-blue-500 rounded-full shadow-md shadow-blue-500/30 @break
                                            @case('Epic') text-purple-300 ring-1 ring-purple-500 rounded-lg aura-epic @break
                                            @case('Legendary') text-amber-300 ring-2 ring-amber-400/75 rounded-full aura-legendary @break
                                            @case('Mythic') text-red-400 ring-2 ring-red-500/75 rounded-lg aura-mythic @break
                                            @case('Secret') ring-2 ring-fuchsia-500/75 rounded-full aura-secret @break
                                            @default text-gray-400 border border-gray-600 rounded-lg
                                    @endswitch
                                    ">
                                        {{ $fish->rarity }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $fish->sell_price_per_kg }} Coins</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $fish->catch_probability }}%</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('fishes.show', $fish) }}" class="text-blue-400 hover:text-blue-300 mr-3">Lihat</a>
                                    <a href="{{ route('fishes.edit', $fish) }}" class="text-yellow-400 hover:text-yellow-300 mr-3">Edit</a>
                                    
                                    <form action="{{ route('fishes.destroy', $fish) }}" method="POST" class="inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400">
                                            Hapus
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-400">
                                    Tidak ada data ikan ditemukan (atau tidak ada yang lolos filter).
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $fishes->links() }}
        </div>

    </div> 
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteForms = document.querySelectorAll('.delete-form');
            
            deleteForms.forEach(form => {
                form.addEventListener('submit', function (event) {
                    event.preventDefault(); 
                    
                    Swal.fire({
                        title: 'Anda yakin?',
                        text: "Data ikan ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal',
                        
                        background: '#1f2937', 
                        color: '#d1d5db', 
                        confirmButtonColor: '#e11d48',
                        cancelButtonColor: '#4b5563', 

                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush