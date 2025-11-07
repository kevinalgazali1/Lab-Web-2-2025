<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Fish It Management')</title>
    
    <style>
        body {
            background-image: url('https://i.pinimg.com/1200x/86/73/e3/8673e3de039970dcdb9890f915aff318.jpg');
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
        }

        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-4px); } }
        @keyframes pulse-purple { 0%, 100% { box-shadow: 0 0 15px 5px rgba(192, 132, 252, 0.4); } 50% { box-shadow: 0 0 25px 10px rgba(192, 132, 252, 0.6); } }
        .aura-epic { animation: pulse-purple 2.5s ease-in-out infinite; }
        @keyframes shimmer-gold { 0%, 100% { box-shadow: 0 0 20px 7px rgba(251, 191, 36, 0.5); } 50% { box-shadow: 0 0 30px 12px rgba(251, 211, 146, 0.7); } }
        .aura-legendary { animation: shimmer-gold 2.5s ease-in-out infinite, float 3s ease-in-out infinite; }
        @keyframes pulse-fire { 0%, 100% { box-shadow: 0 0 25px 10px rgba(248, 113, 113, 0.6); } 50% { box-shadow: 0 0 35px 15px rgba(239, 68, 68, 0.8); } }
        .aura-mythic { animation: pulse-fire 1.5s ease-in-out infinite, float 2s ease-in-out infinite; }
        @keyframes prism-glow { 0% { box-shadow: 0 0 30px 10px rgba(217, 70, 239, 0.7); } 33% { box-shadow: 0 0 30px 10px rgba(139, 92, 246, 0.7); } 66% { box-shadow: 0 0 30px 10px rgba(59, 130, 246, 0.7); } 100% { box-shadow: 0 0 30px 10px rgba(217, 70, 239, 0.7); } }
        @keyframes prism-text { 0% { color: #f0abfc; } 33% { color: #a78bfa; } 66% { color: #93c5fd; } 100% { color: #f0abfc; } }
        .aura-secret { animation: prism-glow 4s linear infinite, float 1s ease-in-out infinite, prism-text 4s linear infinite; }
    </style>

    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-900 text-gray-200">

    <nav class="bg-gray-800 p-4 sticky top-0 z-50 shadow-md mb-6"
            style="background-color: rgba(31, 41, 55, 0.9);">
        <div class="container mx-auto flex justify-between">
            <a href="{{ route('fishes.index') }}" class="text-white font-bold">Fish It Roblox</a>
            <div>
                <a href="{{ route('fishes.index') }}" class="text-gray-300 hover:text-white px-3">Daftar Ikan</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-4">

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Oops! Ada kesalahan:</strong>
                <ul class="list-disc pl-5 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @stack('scripts')
</body>
</html>