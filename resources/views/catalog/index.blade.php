@extends('layouts.app')

@section('title', 'Katalog Produk')
@section('meta_description', 'Jelajahi koleksi furnitur premium Cozyture — sofa, meja, lemari, dan lebih banyak lagi.')

@push('styles')
<style>
    .product-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .product-card:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(44,40,37,0.1); }
    .product-card img { transition: transform 0.5s ease; }
    .product-card:hover img { transform: scale(1.04); }
    .reveal { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .reveal.visible { opacity: 1; transform: none; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="bg-cream-dark border-b border-sand/20 py-10">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-1">Cozyture</p>
        <h1 class="font-display text-4xl text-charcoal">
            {{ $activeCategory ? $activeCategory->name : 'Semua Produk' }}
        </h1>
        @if($activeCategory?->description)
        <p class="text-sm text-charcoal/50 mt-2 max-w-lg">{{ $activeCategory->description }}</p>
        @endif
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 lg:px-12 py-10">
    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Sidebar Filter --}}
        <aside class="lg:w-56 shrink-0">

            {{-- Search --}}
            <form method="GET" action="{{ route('catalog.index') }}" class="mb-6">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari produk..."
                           class="w-full pl-9 pr-4 py-2.5 text-sm border border-sand/30 rounded-sm bg-white
                                  focus:outline-none focus:border-walnut text-charcoal placeholder-sand-dark">
                    <svg class="absolute left-3 top-3 w-4 h-4 text-sand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                    @if(request('sort'))<input type="hidden" name="sort" value="{{ request('sort') }}">@endif
                </div>
            </form>

            {{-- Kategori --}}
            <div class="mb-6">
                <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-3">Kategori</p>
                <div class="space-y-1">
                    <a href="{{ route('catalog.index', request()->except('category', 'page')) }}"
                       class="block text-sm py-1.5 px-2 rounded transition-colors
                              {{ ! request('category') ? 'text-walnut font-medium bg-walnut/5' : 'text-charcoal/60 hover:text-charcoal' }}">
                        Semua Produk
                    </a>
                    @foreach($categories as $cat)
                    <a href="{{ route('catalog.index', array_merge(request()->except('page'), ['category' => $cat->slug])) }}"
                       class="block text-sm py-1.5 px-2 rounded transition-colors
                              {{ request('category') === $cat->slug ? 'text-walnut font-medium bg-walnut/5' : 'text-charcoal/60 hover:text-charcoal' }}">
                        {{ $cat->name }}
                        <span class="text-xs text-sand ml-1">({{ $cat->products_count }})</span>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Harga --}}
            <div class="mb-6">
                <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-3">Rentang Harga</p>
                <form method="GET" action="{{ route('catalog.index') }}">
                    @foreach(request()->except(['min_price','max_price','page']) as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <div class="space-y-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min (Rp)"
                               class="w-full px-3 py-2 text-sm border border-sand/30 rounded-sm bg-white focus:outline-none focus:border-walnut text-charcoal">
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max (Rp)"
                               class="w-full px-3 py-2 text-sm border border-sand/30 rounded-sm bg-white focus:outline-none focus:border-walnut text-charcoal">
                        <button type="submit"
                                class="w-full py-2 text-xs tracking-widest uppercase bg-walnut text-cream rounded-sm hover:bg-walnut-dark transition-colors">
                            Terapkan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Stok --}}
            <div class="mb-6">
                <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-3">Ketersediaan</p>
                <a href="{{ route('catalog.index', array_merge(request()->except(['in_stock','page']), request('in_stock') ? [] : ['in_stock' => 1])) }}"
                   class="flex items-center gap-2 text-sm transition-colors
                          {{ request('in_stock') ? 'text-walnut font-medium' : 'text-charcoal/60 hover:text-charcoal' }}">
                    <span class="w-4 h-4 border {{ request('in_stock') ? 'bg-walnut border-walnut' : 'border-sand' }} rounded flex items-center justify-center shrink-0">
                        @if(request('in_stock'))
                        <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                        @endif
                    </span>
                    Stok tersedia
                </a>
            </div>

            {{-- Reset --}}
            @if(request()->hasAny(['category','search','min_price','max_price','in_stock']))
            <a href="{{ route('catalog.index') }}"
               class="block text-center text-xs text-sand-dark hover:text-walnut transition-colors underline underline-offset-2">
                Reset semua filter
            </a>
            @endif

        </aside>

        {{-- Product Grid --}}
        <div class="flex-1 min-w-0">

            {{-- Toolbar --}}
            <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
                <p class="text-sm text-charcoal/50">
                    <span class="text-charcoal font-medium">{{ $products->total() }}</span> produk ditemukan
                </p>
                <select onchange="window.location = this.value"
                        class="text-sm border border-sand/30 rounded-sm px-3 py-2 bg-white text-charcoal focus:outline-none focus:border-walnut cursor-pointer">
                    @foreach(['default'=>'Urutan Default','newest'=>'Terbaru','price_asc'=>'Harga: Terendah','price_desc'=>'Harga: Tertinggi'] as $val => $label)
                    <option value="{{ route('catalog.index', array_merge(request()->except(['sort','page']), ['sort' => $val])) }}"
                            {{ request('sort','default') === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            @if($products->isEmpty())
            <div class="text-center py-20">
                <p class="font-display text-3xl text-charcoal/20 mb-3">Produk tidak ditemukan</p>
                <p class="text-sm text-charcoal/40 mb-6">Coba ubah filter atau kata kunci pencarian.</p>
                <a href="{{ route('catalog.index') }}" class="text-xs tracking-widest uppercase text-walnut hover:underline">
                    Lihat semua produk
                </a>
            </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach($products as $i => $product)
                <a href="{{ route('catalog.show', $product->slug) }}"
                   class="product-card bg-ivory rounded-sm overflow-hidden reveal"
                   style="transition-delay: {{ ($i % 6) * 0.07 }}s">
                    <div class="aspect-[4/3] overflow-hidden bg-cream relative">
                        @if($product->primaryImage)
                            <img src="{{ asset('storage/' . $product->primaryImage->path) }}"
                                 alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-sand/30 font-display text-3xl italic">foto</div>
                        @endif
                        @if($product->is_featured)
                        <span class="absolute top-3 left-3 bg-walnut text-cream text-[0.6rem] tracking-widest uppercase px-2.5 py-1">Unggulan</span>
                        @endif
                        @if(! $product->is_in_stock)
                        <span class="absolute top-3 right-3 bg-charcoal/70 text-cream text-[0.6rem] tracking-widest uppercase px-2.5 py-1">Habis</span>
                        @endif
                    </div>
                    <div class="p-4">
                        <p class="text-[0.6rem] tracking-widest uppercase text-sand mb-1">{{ $product->category->name ?? '' }}</p>
                        <h3 class="font-display text-lg text-charcoal mb-1 leading-tight">{{ $product->name }}</h3>
                        @if($product->material)
                        <p class="text-xs text-charcoal/40 mb-2">{{ $product->material }}</p>
                        @endif
                        <p class="text-walnut font-medium text-sm">{{ $product->formatted_price }}</p>
                    </div>
                </a>
                @endforeach
            </div>

            @if($products->hasPages())
            <div class="mt-10 flex justify-center">
                {{ $products->links('vendor.pagination.cozyture') }}
            </div>
            @endif
            @endif

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
</script>
@endpush