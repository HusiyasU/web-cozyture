<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Cozyture') — Toko Furnitur Premium</title>
    <meta name="description" content="@yield('meta_description', 'Cozyture — Hadirkan furnitur impian ke ruang hidupmu.')">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    {{-- Tailwind CSS CDN (dev only — ganti Vite di production) --}}
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
                    letterSpacing: {
                        widest2: '0.2em',
                    }
                }
            }
        }
    </script>

    <style>
        /* Base */
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: "DM Sans", sans-serif;
            background-color: #FAF7F2;
            color: #2C2825;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        #navbar {
            transition: background 0.35s, box-shadow 0.35s, padding 0.35s;
        }
        #navbar.scrolled {
            background: rgba(250, 247, 242, 0.97);
            backdrop-filter: blur(8px);
            box-shadow: 0 1px 0 rgba(92,61,46,0.1);
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        /* Nav links */
        .nav-link {
            font-family: "DM Sans", sans-serif;
            font-size: 0.8rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #2C2825;
            position: relative;
            padding-bottom: 2px;
            transition: color 0.2s;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px; left: 0;
            width: 0; height: 1px;
            background: #5C3D2E;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after,
        .nav-link.active::after { width: 100%; }
        .nav-link.active { color: #5C3D2E; }

        /* Hamburger */
        .hamburger span {
            display: block;
            width: 22px; height: 1.5px;
            background: #2C2825;
            transition: transform 0.3s, opacity 0.3s;
            transform-origin: center;
        }
        .hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .hamburger.open span:nth-child(2) { opacity: 0; }
        .hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* Mobile menu */
        #mobile-menu {
            transition: max-height 0.4s ease, opacity 0.4s ease;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
        }
        #mobile-menu.open {
            max-height: 400px;
            opacity: 1;
        }

        /* Footer */
        footer a { transition: color 0.2s; }
        footer a:hover { color: #C9B99A; }

        /* Flash alert */
        .alert-enter {
            animation: slideDown 0.4s ease forwards;
        }
        @keyframes slideDown {
            from { transform: translateY(-16px); opacity: 0; }
            to   { transform: translateY(0);     opacity: 1; }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #FAF7F2; }
        ::-webkit-scrollbar-thumb { background: #C9B99A; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #5C3D2E; }
    </style>

    @stack('styles')
</head>

<body class="font-body">

    {{-- ===== NAVBAR ===== --}}
    <header id="navbar" class="fixed top-0 left-0 right-0 z-50 px-6 lg:px-12 py-5">
        <div class="max-w-7xl mx-auto flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex flex-col leading-none group">
                <span class="font-display text-2xl font-semibold text-walnut tracking-wide group-hover:text-walnut-dark transition-colors">
                    Cozyture
                </span>
                <span class="text-[0.6rem] tracking-widest2 uppercase text-sand-dark font-body font-light mt-0.5">
                    Furniture & Living
                </span>
            </a>

            {{-- Desktop Nav --}}
            <nav class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}"
                   class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('catalog.index') }}"
                   class="nav-link {{ request()->routeIs('catalog.*') ? 'active' : '' }}">
                    Katalog
                </a>
                <a href="{{ route('about') }}"
                   class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                    Tentang Kami
                </a>
                <a href="{{ route('contact') }}"
                   class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                    Kontak
                </a>
            </nav>

            {{-- CTA Button --}}
            <div class="hidden md:flex items-center gap-4">
                <a href="{{ route('order.create') }}"
                   class="px-5 py-2.5 bg-walnut text-cream text-xs tracking-widest uppercase font-body
                          hover:bg-walnut-dark transition-colors duration-200 rounded-sm">
                    Pesan Sekarang
                </a>
            </div>

            {{-- Hamburger --}}
            <button id="hamburger-btn" class="hamburger md:hidden flex flex-col gap-[5px] p-1 focus:outline-none" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="md:hidden bg-ivory border-t border-sand/30 mt-4 -mx-6 px-6">
            <nav class="flex flex-col py-4 gap-4">
                <a href="{{ route('home') }}"
                   class="nav-link self-start {{ request()->routeIs('home') ? 'active' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('catalog.index') }}"
                   class="nav-link self-start {{ request()->routeIs('catalog.*') ? 'active' : '' }}">
                    Katalog
                </a>
                <a href="{{ route('about') }}"
                   class="nav-link self-start {{ request()->routeIs('about') ? 'active' : '' }}">
                    Tentang Kami
                </a>
                <a href="{{ route('contact') }}"
                   class="nav-link self-start {{ request()->routeIs('contact') ? 'active' : '' }}">
                    Kontak
                </a>
                <a href="{{ route('order.create') }}"
                   class="mt-2 inline-block px-5 py-2.5 bg-walnut text-cream text-xs tracking-widest
                          uppercase font-body hover:bg-walnut-dark transition-colors rounded-sm self-start">
                    Pesan Sekarang
                </a>
            </nav>
        </div>
    </header>

    {{-- ===== FLASH MESSAGES ===== --}}
    @if(session('success') || session('error') || session('info'))
    <div class="fixed top-20 right-4 z-50 max-w-sm alert-enter" id="flash-alert">
        <div class="flex items-start gap-3 px-5 py-4 rounded-sm shadow-md
            {{ session('success') ? 'bg-walnut text-cream' : (session('error') ? 'bg-red-700 text-white' : 'bg-sand text-charcoal') }}">
            <span class="text-sm font-body mt-0.5">
                {{ session('success') ?? session('error') ?? session('info') }}
            </span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-auto opacity-70 hover:opacity-100 text-lg leading-none">&times;</button>
        </div>
    </div>
    @endif

    {{-- ===== PAGE CONTENT ===== --}}
    <main class="flex-1 pt-20">
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-charcoal text-cream/70 mt-auto">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 py-14">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

                {{-- Brand --}}
                <div class="md:col-span-2">
                    <p class="font-display text-3xl text-cream mb-2">Cozyture</p>
                    <p class="text-[0.6rem] tracking-widest2 uppercase text-sand mb-4">Furniture & Living</p>
                    <p class="text-sm leading-relaxed text-cream/60 max-w-xs">
                        Kami menghadirkan furnitur berkualitas tinggi dari supplier terpercaya
                        langsung ke rumah Anda. Nyaman, elegan, dan tahan lama.
                    </p>
                </div>

                {{-- Nav Links --}}
                <div>
                    <p class="text-[0.65rem] tracking-widest2 uppercase text-sand mb-4">Navigasi</p>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-sand transition-colors">Beranda</a></li>
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-sand transition-colors">Katalog Produk</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-sand transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-sand transition-colors">Kontak</a></li>
                        <li><a href="{{ route('order.create') }}" class="hover:text-sand transition-colors">Pesan Sekarang</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <p class="text-[0.65rem] tracking-widest2 uppercase text-sand mb-4">Hubungi Kami</p>
                    <ul class="space-y-2.5 text-sm text-cream/60">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-sand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-sand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>hello@cozyture.id</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-sand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Jl. Kayu Manis No. 12,<br>Banjarmasin, Kalimantan Selatan</span>
                        </li>
                    </ul>
                </div>

            </div>

            {{-- Bottom bar --}}
            <div class="mt-12 pt-6 border-t border-cream/10 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-cream/30">
                <p>&copy; {{ date('Y') }} Cozyture. Hak cipta dilindungi.</p>
                <p>Dibuat dengan <span class="text-sand/60">♥</span> untuk hunian yang nyaman</p>
            </div>
        </div>
    </footer>

    {{-- ===== SCRIPTS ===== --}}
    <script>
        // Scroll navbar
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 40);
        });

        // Mobile menu toggle
        const hamburger = document.getElementById('hamburger-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('open');
            mobileMenu.classList.toggle('open');
        });

        // Auto-dismiss flash alert
        const flash = document.getElementById('flash-alert');
        if (flash) setTimeout(() => flash.remove(), 5000);
    </script>

    @stack('scripts')
</body>
</html>