<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title', 'Dashboard') | Cozyture</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream:    { DEFAULT: '#F5F0E8', dark: '#EDE6D6' },
                        walnut:   { DEFAULT: '#5C3D2E', light: '#7A5540', dark: '#3E2518' },
                        sand:     { DEFAULT: '#C9B99A', light: '#DDD0BC', dark: '#A8967A' },
                        charcoal: { DEFAULT: '#2C2825', light: '#4A433E' },
                        ivory:    '#FAF7F2',
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
            background: #F0EBE3;
            color: #2C2825;
        }

        /* Sidebar */
        #sidebar {
            transition: transform 0.3s ease;
        }

        /* Sidebar link */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 14px;
            border-radius: 6px;
            font-size: 0.82rem;
            color: rgba(250,247,242,0.6);
            transition: background 0.2s, color 0.2s;
            letter-spacing: 0.01em;
        }
        .sidebar-link:hover {
            background: rgba(250,247,242,0.08);
            color: #FAF7F2;
        }
        .sidebar-link.active {
            background: rgba(201,185,154,0.18);
            color: #DDD0BC;
        }
        .sidebar-link svg {
            width: 16px; height: 16px;
            flex-shrink: 0;
            opacity: 0.7;
        }
        .sidebar-link.active svg { opacity: 1; }

        /* Sidebar section label */
        .sidebar-section {
            font-size: 0.6rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(201,185,154,0.45);
            padding: 0 14px;
            margin: 16px 0 6px;
        }

        /* Content card */
        .admin-card {
            background: #FAF7F2;
            border-radius: 10px;
            border: 1px solid rgba(92,61,46,0.08);
            box-shadow: 0 1px 3px rgba(44,40,37,0.05);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(201,185,154,0.4); border-radius: 3px; }

        /* Table */
        .admin-table th {
            font-size: 0.67rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #A8967A;
            font-weight: 500;
            padding: 12px 16px;
            border-bottom: 1px solid rgba(92,61,46,0.1);
        }
        .admin-table td {
            padding: 12px 16px;
            font-size: 0.85rem;
            border-bottom: 1px solid rgba(92,61,46,0.05);
            color: #4A433E;
        }
        .admin-table tr:last-child td { border-bottom: none; }
        .admin-table tr:hover td { background: rgba(201,185,154,0.06); }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 100px;
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 0.04em;
        }

        /* Alert */
        .alert-enter { animation: slideDown 0.3s ease forwards; }
        @keyframes slideDown {
            from { transform: translateY(-10px); opacity: 0; }
            to   { transform: translateY(0);     opacity: 1; }
        }
    </style>

    @stack('styles')
</head>

<body class="font-body min-h-screen">
<div class="flex min-h-screen">

    {{-- ===== SIDEBAR ===== --}}
    <aside id="sidebar" class="w-56 shrink-0 bg-charcoal flex flex-col min-h-screen fixed left-0 top-0 z-40 lg:relative">

        {{-- Logo --}}
        <div class="px-5 py-6 border-b border-cream/5">
            <a href="{{ route('home') }}" target="_blank" class="group">
                <p class="font-display text-xl text-cream group-hover:text-sand transition-colors">Cozyture</p>
                <p class="text-[0.55rem] tracking-widest uppercase text-sand/40 mt-0.5">Admin Panel</p>
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 overflow-y-auto">

            <p class="sidebar-section">Utama</p>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M3 7a2 2 0 012-2h4a2 2 0 012 2v4a2 2 0 01-2 2H5a2 2 0 01-2-2V7zM13 7a2 2 0 012-2h2a2 2 0 012 2v10a2 2 0 01-2 2h-2a2 2 0 01-2-2V7zM3 15a2 2 0 012-2h4a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2z"/>
                </svg>
                Dashboard
            </a>

            <p class="sidebar-section">Katalog</p>

            <a href="{{ route('admin.products.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
                Produk
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Kategori
            </a>

            <p class="sidebar-section">Transaksi</p>

            <a href="{{ route('admin.orders.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Pesanan
                @php $pendingCount = \App\Models\Order::where('status','pending')->count(); @endphp
                @if($pendingCount > 0)
                <span class="ml-auto bg-amber-600/80 text-amber-100 text-[0.6rem] px-1.5 py-0.5 rounded-full">
                    {{ $pendingCount }}
                </span>
                @endif
            </a>

            <p class="sidebar-section">Sistem</p>

            <a href="{{ route('admin.settings.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Pengaturan
            </a>

        </nav>

        {{-- User & Logout --}}
        <div class="px-3 py-4 border-t border-cream/5">
            <div class="flex items-center gap-3 px-2 mb-3">
                <div class="w-7 h-7 rounded-full bg-sand/20 flex items-center justify-center text-sand text-xs font-medium">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="min-w-0">
                    <p class="text-cream/80 text-xs truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-cream/30 text-[0.6rem] truncate">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="sidebar-link w-full text-left hover:bg-red-900/20 hover:text-red-300">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>

    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="flex-1 flex flex-col min-w-0 lg:ml-0 ml-56">

        {{-- Top bar --}}
        <header class="sticky top-0 z-30 bg-cream/80 backdrop-blur border-b border-sand/20 px-6 py-3.5 flex items-center gap-4">
            {{-- Mobile sidebar toggle --}}
            <button id="sidebar-toggle" class="lg:hidden p-1 text-charcoal/60 hover:text-charcoal" aria-label="Toggle sidebar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-xs text-charcoal/40 min-w-0">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-charcoal transition-colors">Admin</a>
                @hasSection('breadcrumb')
                    <span>/</span>
                    <span class="text-charcoal/70 truncate">@yield('breadcrumb')</span>
                @endif
            </div>

            {{-- Page title --}}
            <h1 class="font-display text-lg text-charcoal ml-auto hidden sm:block">
                @yield('title', 'Dashboard')
            </h1>
        </header>

        {{-- Flash Messages --}}
        @if(session('success') || session('error') || session('info'))
        <div class="px-6 pt-4 alert-enter">
            <div class="flex items-center gap-3 px-4 py-3 rounded-md text-sm
                {{ session('success') ? 'bg-walnut/10 text-walnut border border-walnut/20' : '' }}
                {{ session('error')   ? 'bg-red-50 text-red-700 border border-red-200'    : '' }}
                {{ session('info')    ? 'bg-sand/20 text-charcoal border border-sand/30'   : '' }}">
                @if(session('success'))
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                @elseif(session('error'))
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                @endif
                <span>{{ session('success') ?? session('error') ?? session('info') }}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-auto opacity-50 hover:opacity-100">&times;</button>
            </div>
        </div>
        @endif

        {{-- Page Content --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="px-6 py-3 border-t border-sand/20 text-xs text-charcoal/30 text-center">
            &copy; {{ date('Y') }} Cozyture Admin Panel
        </footer>
    </div>

</div>

{{-- Overlay for mobile sidebar --}}
<div id="sidebar-overlay" class="fixed inset-0 bg-black/30 z-30 hidden lg:hidden"></div>

<script>
    // Mobile sidebar toggle
    const sidebarEl  = document.getElementById('sidebar');
    const toggleBtn  = document.getElementById('sidebar-toggle');
    const overlay    = document.getElementById('sidebar-overlay');

    function closeSidebar() {
        sidebarEl.style.transform = 'translateX(-100%)';
        overlay.classList.add('hidden');
    }
    function openSidebar() {
        sidebarEl.style.transform = 'translateX(0)';
        overlay.classList.remove('hidden');
    }

    // Default: hide on mobile
    if (window.innerWidth < 1024) closeSidebar();

    toggleBtn?.addEventListener('click', () => {
        const isHidden = sidebarEl.style.transform === 'translateX(-100%)';
        isHidden ? openSidebar() : closeSidebar();
    });
    overlay?.addEventListener('click', closeSidebar);
</script>

@stack('scripts')
</body>
</html>