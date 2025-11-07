@extends('layouts.app')

@section('extra-class', 'transparent-mode')

@section('title', 'Daftar Ikan')

@section('content')
<h2 class="mb-4 text-center fw-bold text-lavender">Detail Ikan</h2>

@php
    $minWeight = '-';
    $maxWeight = '-';

    if (!empty($fish->weight_range)) {
        preg_match_all('/\d+(\.\d+)?/', $fish->weight_range, $matches);
        if (count($matches[0]) >= 2) {
            $minWeight = $matches[0][0] . ' kg';
            $maxWeight = $matches[0][1] . ' kg';
        }
    }
@endphp

<div class="card fish-detail shadow-lg p-4 rounded-4 mx-auto" style="max-width: 600px;">
    <div class="fish-item mb-2"><strong>Nama Ikan:</strong> <span>{{ $fish->name }}</span></div>
    <div class="fish-item mb-2"><strong>Rarity:</strong> <span>{{ $fish->rarity }}</span></div>
    <div class="fish-item mb-2"><strong>Berat Minimum:</strong> <span>{{ $minWeight }}</span></div>
    <div class="fish-item mb-2"><strong>Berat Maksimum:</strong> <span>{{ $maxWeight }}</span></div>
    <div class="fish-item mb-2"><strong>Rentang Berat:</strong> <span>{{ $fish->weight_range ?? '-' }}</span></div>
    <div class="fish-item mb-2"><strong>Harga per Kg:</strong> <span>{{ $fish->formatted_price ?? '-' }}</span></div>
    <div class="fish-item mb-2"><strong>Peluang Tertangkap:</strong> <span>{{ $fish->catch_probability ?? '-' }}%</span></div>
    <div class="fish-item mb-2"><strong>Deskripsi:</strong> 
        <span>{{ $fish->description ?: 'Belum ada deskripsi.' }}</span>
    </div>
    <div class="fish-item mb-2"><strong>Waktu Dibuat:</strong> <span>{{ $fish->created_at }}</span></div>
    <div class="fish-item mb-2"><strong>Terakhir Diperbarui:</strong> <span>{{ $fish->updated_at }}</span></div>

    <div class="mt-4 text-center">
        <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-lavender px-4 me-2">Edit</a>
        <a href="{{ route('fishes.index') }}" class="btn btn-pink px-4">Kembali</a>
    </div>
</div>

<style>
    /* 🌸 Background pastel lembut */
    body {
        background: linear-gradient(135deg, #fce7f3 0%, #f3e8ff 50%, #fdf2f8 100%);
        font-family: "Poppins", sans-serif;
        min-height: 100vh;
        margin: 0;
    }

    .transparent-mode {
        background: rgba(255, 255, 255, 0.65) !important;
        backdrop-filter: blur(12px);
        box-shadow: 0 10px 40px rgba(186, 104, 200, 0.15);
    }

    /* 🌷 Card lembut dengan efek kaca */
    .fish-detail {
        background: rgba(255, 255, 255, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.4);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 20px;
    }

    .fish-detail:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(240, 171, 252, 0.25);
    }

    .fish-item strong {
        display: inline-block;
        width: 180px;
        color: #7e22ce; /* lavender deep */
    }

    .fish-item span {
        color: #9d174d; /* soft pink text */
    }

    h2.text-lavender {
        color: #9333ea;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.08);
    }

    /* 💜 Tombol tema lavender & pink pastel */
    .btn-lavender {
        background-color: #c084fc;
        border: none;
        color: white;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-lavender:hover {
        background-color: #a855f7;
        box-shadow: 0 4px 10px rgba(168, 85, 247, 0.3);
    }

    .btn-pink {
        background-color: #f9a8d4;
        border: none;
        color: #701a75;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-pink:hover {
        background-color: #f472b6;
        color: white;
        box-shadow: 0 4px 10px rgba(244, 114, 182, 0.3);
    }
</style>
@endsection
