<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') — Cozyture Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream:   { DEFAULT: '#F5F0E8', dark: '#EDE6D6' },
                        walnut:  { DEFAULT: '#5C3D2E', light: '#7A5540', dark: '#3E2518' },
                        sand:    { DEFAULT: '#C9B99A', light: '#DDD0BC', dark: '#A8967A' },
                        charcoal:{ DEFAULT: '#2C2825', light: '#4A433E' },
                        ivory:   '#FAF7F2',
                    },
                    fontFamily: {
                        display: ['"Cormorant Garamond"', 'Georgia', 'serif'],
                        body:    ['"DM Sans"', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body {
            font-family: "DM Sans", sans-serif;
            background: #2C2825;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Decorative grain texture */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            opacity: 0.5;
        }

        .auth-card {
            background: #FAF7F2;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,0.4);
        }

        .input-field {
            width: 100%;
            padding: 10px 14px;
            background: white;
            border: 1px solid rgba(92,61,46,0.15);
            border-radius: 6px;
            font-family: "DM Sans", sans-serif;
            font-size: 0.875rem;
            color: #2C2825;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }
        .input-field:focus {
            border-color: #5C3D2E;
            box-shadow: 0 0 0 3px rgba(92,61,46,0.08);
        }
        .input-field::placeholder { color: #C9B99A; }

        .btn-primary {
            width: 100%;
            padding: 11px 20px;
            background: #5C3D2E;
            color: #F5F0E8;
            font-family: "DM Sans", sans-serif;
            font-size: 0.75rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-primary:hover { background: #3E2518; }
        .btn-primary:active { transform: translateY(1px); }

        label {
            display: block;
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #A8967A;
            margin-bottom: 6px;
        }
    </style>
</head>

<body>
    <div class="auth-card w-full max-w-sm mx-4">

        {{-- Left accent strip --}}
        <div class="h-1 bg-gradient-to-r from-walnut via-sand to-walnut-dark"></div>

        <div class="px-8 py-10">
            {{-- Logo --}}
            <div class="text-center mb-8">
                <p class="font-display text-3xl text-walnut">Cozyture</p>
                <p class="text-[0.6rem] tracking-widest uppercase text-sand-dark mt-1">Admin Panel</p>
            </div>

            {{-- Validation errors --}}
            @if($errors->any())
            <div class="mb-5 px-4 py-3 bg-red-50 border border-red-200 rounded-md">
                <ul class="text-xs text-red-600 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Session message --}}
            @if(session('status'))
            <div class="mb-5 px-4 py-3 bg-walnut/10 border border-walnut/20 rounded-md">
                <p class="text-xs text-walnut">{{ session('status') }}</p>
            </div>
            @endif

            {{-- Content slot --}}
            @yield('content')
        </div>

        {{-- Bottom link --}}
        <div class="px-8 py-4 bg-cream border-t border-sand/20 text-center">
            <a href="{{ route('home') }}" class="text-xs text-sand-dark hover:text-walnut transition-colors">
                &larr; Kembali ke Website
            </a>
        </div>

    </div>
</body>
</html>