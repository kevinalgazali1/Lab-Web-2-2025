<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Fish It Manager')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --lavender-light: #f3e8ff;
            --lavender: #c4b5fd;
            --lavender-dark: #a78bfa;
            --pink-soft: #fbcfe8;
            --pink-medium: #f9a8d4;
            --pink-dark: #f472b6;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(180deg, var(--lavender-light) 0%, var(--pink-soft) 50%, var(--lavender) 100%);
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif;
            color: #4b2e83;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--lavender-dark) 0%, var(--pink-dark) 100%) !important;
            box-shadow: 0 4px 12px rgba(244, 114, 182, 0.3);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.6rem;
            color: white !important;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.15);
        }
        
        .navbar-brand i {
            animation: floaty 3s ease-in-out infinite;
        }
        
        @keyframes floaty {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0 5px;
            padding: 8px 16px !important;
        }
        
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.25);
            color: white !important;
            transform: translateY(-2px);
        }
        
        .container.main-content {
            flex: 1;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 2.5rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 40px rgba(244, 114, 182, 0.2);
            border: 2px solid rgba(244, 114, 182, 0.15);
        }
        
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            animation: slideDown 0.5s ease;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d8b4fe, #c084fc);
            color: white;
            box-shadow: 0 4px 12px rgba(192, 132, 252, 0.4);
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #f9a8d4, #f472b6);
            color: white;
            box-shadow: 0 4px 12px rgba(249, 168, 212, 0.4);
        }
        
        /* Bubble animation (soft pink version) */
        .bubbles {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
            top: 0;
            left: 0;
            pointer-events: none;
        }
        
        .bubble {
            position: absolute;
            bottom: -100px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            opacity: 0.5;
            animation: rise 10s infinite ease-in;
        }

        .bubble:nth-child(odd) {
            background: rgba(249, 168, 212, 0.35);
        }
        .bubble:nth-child(even) {
            background: rgba(196, 181, 253, 0.35);
        }

        @keyframes rise {
            0% { bottom: -100px; transform: translateX(0); }
            50% { transform: translateX(60px); }
            100% { bottom: 1080px; transform: translateX(-100px); }
        }
        
        nav, .container.main-content, footer {
            position: relative;
            z-index: 1;
        }
        
        footer {
            background: linear-gradient(135deg, var(--pink-dark) 0%, var(--lavender-dark) 100%);
            color: white;
            padding: 1.5rem 0;
            margin-top: auto;
            box-shadow: 0 -4px 12px rgba(244, 114, 182, 0.3);
        }
        
        footer p {
            margin: 0;
            opacity: 0.9;
            font-weight: 500;
        }
    </style>
</head>
<body>
<!-- Soft Bubbles -->
<div class="bubbles">
    <div class="bubble"></div><div class="bubble"></div><div class="bubble"></div>
    <div class="bubble"></div><div class="bubble"></div><div class="bubble"></div>
    <div class="bubble"></div><div class="bubble"></div><div class="bubble"></div>
    <div class="bubble"></div>
</div>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ route('fishes.index') }}">
        <i class="fas fa-fish"></i> FishIt Manager
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <div class="navbar-nav ms-auto">
        <a class="nav-link" href="{{ route('fishes.index') }}">
            <i class="fas fa-home"></i> Home
        </a>
        <a class="nav-link" href="{{ route('fishes.create') }}">
            <i class="fas fa-plus-circle"></i> Add New
        </a>
      </div>
    </div>
  </div>
</nav>

<div class="container main-content @yield('extra-class')">
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> Please correct the errors below.
        </div>
    @endif

    @yield('content')
</div>

<footer>
  <div class="container">
    <div class="text-center">
      <p>&copy; {{ date('Y') }} FishIt Manager. All rights reserved.</p>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
