<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fish It Simulator</title>

    <style>
        :root {
            --sand: #EFD6AC;
            --blue-soft: #A2BEDC;
            --deep-ocean: #183A37;
            --white: #ffffff;
        }

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(180deg, var(--sand), var(--blue-soft));
            font-family: "Segoe UI", sans-serif;
            color: var(--deep-ocean);
            text-align: center;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .waves {
            position: fixed;
            width: 100%;
            height: 100%;
            background: url('https://i.ibb.co/jTW5mLw/wave2.png') repeat-x bottom;
            opacity: .12;
            pointer-events: none;
        }

        h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 25px;
        }

        /* Glossy Water Button */
        .btn {
            padding: 14px 28px;
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--sand);
            background: linear-gradient(180deg, #1f514b, var(--deep-ocean));
            border-radius: 14px;
            border: none;
            cursor: pointer;
            transition: 0.25s ease;
            box-shadow: 0 5px 14px rgba(24, 58, 55, 0.35);
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: "";
            position: absolute;
            top: -70%;
            left: -40%;
            width: 180%;
            height: 220%;
            background: rgba(255,255,255,0.25);
            transform: rotate(25deg);
            transition: .5s;
        }

        .btn:hover::before {
            left: 120%;
        }

        .btn:hover {
            transform: translateY(-4px);
            opacity: 1;
        }

        .container {
            max-width: 650px;
        }
    </style>
</head>
<body>

<div class="waves"></div>

<div class="container">
    <h1>Fish It Simulator</h1>
    <p>Selamat datang! Jelajahi dunia laut dan kelola koleksi ikanmu.</p>

    <a href="{{ route('fishes.index') }}">
        <button class="btn">Masuk ke Database Ikan</button>
    </a>
</div>

</body>
</html>
