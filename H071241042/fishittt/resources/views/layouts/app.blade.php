<!DOCTYPE html>
<html>
<head>
    <title>Fish It Simulator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
    :root {
        --sand: #EFD6AC;
        --blue-soft: #A2BEDC;
        --deep-ocean: #183A37;
        --white: #ffffff;
    }

    body {
        background: linear-gradient(180deg, var(--sand), var(--blue-soft));
        min-height: 100vh;
        font-family: 'Segoe UI', sans-serif;
        color: var(--deep-ocean);
        background-attachment: fixed;
    }

    .ocean-waves {
        position: fixed;
        height: 100%;
        width: 100%;
        background: url('https://i.ibb.co/jTW5mLw/wave2.png') repeat-x bottom;
        opacity: 0.07;
        pointer-events: none;
    }

    /* NAVBAR */
    .custom-navbar {
        background: linear-gradient(90deg, var(--blue-soft), var(--sand));
        box-shadow: 0 3px 12px rgba(0,0,0,0.15);
    }

    .navbar-brand {
        font-weight: bold;
        font-size: 1.55rem;
        color: var(--deep-ocean) !important;
        letter-spacing: .5px;
    }

    /* CARD */
    .content-card {
        background: rgba(255,255,255,0.55);
        backdrop-filter: blur(12px);
        border-radius: 16px;
        padding: 25px;
        border: 1px solid var(--deep-ocean);
        box-shadow: 0 5px 18px rgba(0,0,0,0.15);
    }

    /* TABLE */
    table { color: var(--deep-ocean); }
    thead { background: var(--deep-ocean); color: var(--sand); }
    tbody tr:hover { background: rgba(24, 58, 55, 0.15); }

    /* BUTTONS */
    .btn-modern {
        padding: 8px 14px;
        border-radius: 10px;
        font-weight: bold;
        border: none;
        transition: 0.2s ease;
    }

    .btn-add,
    .btn-edit {
        background: var(--deep-ocean);
        color: var(--sand);
    }

    .btn-detail {
        background: var(--white);
        color: var(--deep-ocean);
        border: 2px solid var(--deep-ocean);
    }

    .btn-delete {
        background: #842a2a;
        color: var(--white);
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        opacity: .9;
    }
    </style>

</head>
<body>

<div class="ocean-waves"></div>

<nav class="navbar custom-navbar mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('fishes.index') }}">Fish It Simulator</a>
    </div>
</nav>

<div class="container mb-5">
    <div class="content-card">
        @yield('content')
    </div>
</div>

</body>
</html>
