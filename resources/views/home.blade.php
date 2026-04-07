@extends('layouts.app')

@section('title', 'Beranda')
@section('meta_description', 'Cozyture — Hadirkan furnitur impian ke ruang hidupmu dengan kualitas premium.')

@push('styles')
<style>
    /* Hero */
    .hero-bg {
        background-color: #2C2825;
        background-image:
            radial-gradient(ellipse at 70% 50%, rgba(92,61,46,0.35) 0%, transparent 60%),
            radial-gradient(ellipse at 20% 80%, rgba(201,185,154,0.1) 0%, transparent 50%);
        min-height: 92vh;
    }

    /* Marquee */
    .marquee-track {
        display: flex;
        gap: 48px;
        animation: marquee 22s linear infinite;
        white-space: nowrap;
    }
    @keyframes marquee {
        from { transform: translateX(0); }
        to   { transform: translateX(-50%); }
    }

    /* Product card */
    .product-card { transition: transform 0.35s ease, box-shadow 0.35s ease; }
    .product-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(44,40,37,0.12); }
    .product-card img { transition: transform 0.5s ease; }
    .product-card:hover img { transform: scale(1.04); }

    /* Reveal animation */
    .reveal { opacity: 0; transform: translateY(24px); transition: opacity 0.7s ease, transform 0.7s ease; }
    .reveal.visible { opacity: 1; transform: none; }
</style>
@endpush

@section('content')

{{-- ===== HERO ===== --}}
<section class="hero-bg flex items-center">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-24 lg:py-0 grid lg:grid-cols-2 gap-16 items-center min-h-[88vh]">

        {{-- Text --}}
        <div class="text-cream">
            <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-5 reveal">
                Toko Furnitur Premium
            </p>
            <h1 class="font-display text-5xl lg:text-7xl leading-[1.08] mb-6 reveal" style="transition-delay:0.1s">
                Ruang hidup<br>
                <em class="text-sand font-normal">yang bercerita</em>
            </h1>
            <p class="text-cream/60 text-base leading-relaxed max-w-md mb-10 reveal" style="transition-delay:0.2s">
                Kami menghadirkan furnitur berkualitas tinggi dari supplier terpercaya —
                dirancang untuk menemani setiap momen berharga di rumahmu.
            </p>
            <div class="flex flex-wrap gap-4 reveal" style="transition-delay:0.3s">
                <a href="{{ route('catalog.index') }}"
                   class="px-7 py-3.5 bg-sand text-charcoal text-xs tracking-widest uppercase
                          hover:bg-sand-light transition-colors rounded-sm">
                    Jelajahi Katalog
                </a>
                <a href="{{ route('order.create') }}"
                   class="px-7 py-3.5 border border-cream/25 text-cream text-xs tracking-widest uppercase
                          hover:bg-cream/10 transition-colors rounded-sm">
                    Pesan Sekarang
                </a>
            </div>
        </div>

        {{-- Hero image placeholder --}}
        <div class="relative hidden lg:block reveal" style="transition-delay:0.2s">
            <div class="aspect-[4/5] bg-walnut/30 rounded-sm overflow-hidden">
                {{-- Ganti src dengan gambar hero asli --}}
                <div class="w-full h-full flex items-center justify-center text-cream/20">
                    <span class="font-display text-6xl italic">hero<br>image</span>
                </div>
            </div>
            {{-- Floating stat card --}}
            <div class="absolute -left-8 bottom-12 bg-ivory px-5 py-4 rounded-sm shadow-xl">
                <p class="font-display text-3xl text-walnut">200+</p>
                <p class="text-[0.65rem] text-sand-dark tracking-wide uppercase">Pilihan Furnitur</p>
            </div>
        </div>

    </div>
</section>

{{-- ===== MARQUEE STRIP ===== --}}
<div class="overflow-hidden bg-walnut py-4 select-none">
    <div class="marquee-track text-cream/40 text-[0.65rem] tracking-widest uppercase">
        @foreach(['Sofa', 'Meja Makan', 'Lemari', 'Kursi', 'Rak Buku', 'Ranjang', 'Nakas', 'Coffee Table',
                  'Sofa', 'Meja Makan', 'Lemari', 'Kursi', 'Rak Buku', 'Ranjang', 'Nakas', 'Coffee Table'] as $item)
            <span>{{ $item }}</span>
            <span class="text-sand/40">·</span>
        @endforeach
    </div>
</div>

{{-- ===== FEATURED PRODUCTS ===== --}}
<section class="max-w-7xl mx-auto px-6 lg:px-12 py-24">
    <div class="flex items-end justify-between mb-12 reveal">
        <div>
            <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-2">Koleksi Pilihan</p>
            <h2 class="font-display text-4xl lg:text-5xl text-charcoal">Produk Unggulan</h2>
        </div>
        <a href="{{ route('catalog.index') }}"
           class="hidden sm:inline-flex items-center gap-2 text-xs tracking-widest uppercase text-walnut hover:text-walnut-dark transition-colors">
            Lihat Semua
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    {{-- Product Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($featuredProducts ?? [] as $product)
        <a href="{{ route('catalog.show', $product->slug) }}"
           class="product-card bg-ivory rounded-sm overflow-hidden reveal">
            <div class="aspect-[4/3] overflow-hidden bg-cream">
                @if($product->primaryImage)
                    <img src="{{ Storage::url($product->primaryImage->path) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-sand/40 font-display text-4xl italic">
                        foto
                    </div>
                @endif
            </div>
            <div class="p-5">
                <p class="text-[0.6rem] tracking-widest uppercase text-sand mb-1">
                    {{ $product->category->name ?? 'Furnitur' }}
                </p>
                <h3 class="font-display text-xl text-charcoal mb-2">{{ $product->name }}</h3>
                <p class="text-sm text-charcoal/50 line-clamp-2 mb-3">{{ $product->short_description }}</p>
                <p class="text-walnut font-medium text-sm">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>
            </div>
        </a>
        @empty
        {{-- Placeholder cards saat data kosong --}}
        @for($i = 0; $i < 3; $i++)
        <div class="product-card bg-ivory rounded-sm overflow-hidden reveal" style="transition-delay:{{ $i * 0.1 }}s">
            <div class="aspect-[4/3] bg-cream flex items-center justify-center text-sand/30 font-display text-4xl italic">
                foto
            </div>
            <div class="p-5">
                <p class="text-[0.6rem] tracking-widest uppercase text-sand mb-1">Kategori</p>
                <h3 class="font-display text-xl text-charcoal mb-2">Nama Produk</h3>
                <p class="text-sm text-charcoal/50 mb-3">Deskripsi singkat produk akan tampil di sini.</p>
                <p class="text-walnut font-medium text-sm">Rp 0</p>
            </div>
        </div>
        @endfor
        @endforelse
    </div>
</section>

{{-- ===== WHY US ===== --}}
<section class="bg-cream-dark py-24">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="text-center mb-14 reveal">
            <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-2">Keunggulan Kami</p>
            <h2 class="font-display text-4xl lg:text-5xl text-charcoal">Mengapa Cozyture?</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
            @foreach([
                ['icon'=>'M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z',
                  'title'=>'Koleksi Beragam',
                  'desc' =>'Lebih dari 200 pilihan furnitur dari berbagai kategori dan gaya desain.'],
                ['icon'=>'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
                  'title'=>'Kualitas Terjamin',
                  'desc' =>'Setiap produk dipilih dari supplier terpercaya dengan standar kualitas ketat.'],
                ['icon'=>'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
                  'title'=>'Konsultasi Gratis',
                  'desc' =>'Tim kami siap membantu kamu memilih furnitur yang sesuai kebutuhan.'],
            ] as $feat)
            <div class="text-center reveal">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-walnut/10 mb-5">
                    <svg class="w-5 h-5 text-walnut" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $feat['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="font-display text-xl text-charcoal mb-2">{{ $feat['title'] }}</h3>
                <p class="text-sm text-charcoal/55 leading-relaxed">{{ $feat['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== CTA BANNER ===== --}}
<section class="bg-charcoal py-20">
    <div class="max-w-3xl mx-auto px-6 text-center reveal">
        <h2 class="font-display text-4xl lg:text-5xl text-cream mb-4">
            Siap menata ruang impianmu?
        </h2>
        <p class="text-cream/50 mb-8 text-sm leading-relaxed">
            Hubungi kami sekarang dan dapatkan rekomendasi furnitur terbaik dari tim Cozyture.
        </p>
        <a href="{{ route('order.create') }}"
           class="inline-block px-8 py-3.5 bg-sand text-charcoal text-xs tracking-widest uppercase
                  hover:bg-sand-light transition-colors rounded-sm">
            Mulai Konsultasi
        </a>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Scroll reveal
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endpush