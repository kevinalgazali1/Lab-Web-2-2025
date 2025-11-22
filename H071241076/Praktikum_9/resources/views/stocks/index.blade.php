@extends('layouts.app')

@section('title', 'Daftar Stok Produk')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Stok per Gudang</h1>
        <a href="{{ route('stocks.create') }}"
            class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
            Transfer Stok
        </a>
    </div>

    <div class="bg-gray-50 p-4 rounded-lg shadow-inner mb-6">
        <form method="GET" action="{{ route('stocks.index') }}">
            <div class="flex items-center space-x-4">
                <div class="grow">
                    <label for="warehouse_id" class="block text-sm font-medium text-gray-700">Filter berdasarkan Gudang</label>
                    <select name="warehouse_id" id="warehouse_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        onchange="this.form.submit()">
                        <option value="">-- Tampilkan Semua Gudang --</option>
                        @foreach($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}"
                            {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                            {{ $warehouse->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-transparent">&nbsp;</label>
                    <a href="{{ route('stocks.index') }}"
                        class="mt-1 inline-block w-full text-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow-sm hover:bg-gray-300 transition duration-300">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Gudang</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Kuantitas</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($stocks as $stock)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $stock->warehouse_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $stock->product_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $stock->total_quantity }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada data stok.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $stocks->links() }}
    </div>

</div>
@endsection