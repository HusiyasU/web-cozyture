@extends('layouts.app')

@section('title', $product->name)
@section('meta_description', $product->short_description)

@push('styles')
<style>
    .thumb { cursor: pointer; transition: opacity 0.2s, border-color 0.2s; }
    .thumb.active { border-color: #5C3D2E; opacity: 1; }
    .thumb:not(.active) { opacity: 0.55; }
    .thumb:hover { opacity: 1; }

    .related-card { transition: transform 0.3s, box-shadow 0.3s; }
    .related-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(44,40,37,0.1); }
    .related-card img { transition: transform 0.4s; }
    .related-card:hover img { transform: scale(1.04); }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="max-w-7xl mx-auto px-6 lg:px-12 py-4">
    <div class="flex items-center gap-2 text-xs text-charcoal/40">
        <a href="{{ route('home') }}" class="hover:text-charcoal transition-colors">Beranda</a>
        <span>/</span>
        <a href="{{ route('catalog.index') }}" class="hover:text-charcoal transition-colors">Katalog</a>
        <span>/</span>
        @if($product->category)
        <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}"
           class="hover:text-charcoal transition-colors">{{ $product->category->name }}</a>
        <span>/</span>
        @endif
        <span class="text-charcoal/70 truncate max-w-[200px]">{{ $product->name }}</span>
    </div>
</div>

{{-- Main Content --}}
<div class="max-w-7xl mx-auto px-6 lg:px-12 pb-16">
    <div class="grid lg:grid-cols-2 gap-12 items-start">

        {{-- ===== GALLERY ===== --}}
        <div class="sticky top-24">
            {{-- Main Image --}}
            <div class="aspect-square bg-cream rounded-sm overflow-hidden mb-3">
                <img id="main-img"
                     src="{{ $product->primary_image_url ?? asset('images/placeholder.jpg') }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover transition-opacity duration-300">
            </div>

            {{-- Thumbnails --}}
            @if($product->images->count() > 1)
            <div class="flex gap-2 overflow-x-auto pb-1">
                @foreach($product->images as $i => $image)
                <button onclick="setImage('{{ asset('storage/' . $image->path) }}', this)"
                        class="thumb shrink-0 w-16 h-16 rounded-sm overflow-hidden border-2
                               {{ $image->is_primary ? 'active border-walnut' : 'border-transparent' }}">
                    <img src="{{ asset('storage/' . $image->path) }}"
                         alt="{{ $image->alt ?? $product->name }}"
                         class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        {{-- ===== PRODUCT INFO ===== --}}
        <div>
            <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-2">
                {{ $product->category->name ?? 'Furnitur' }}
            </p>
            <h1 class="font-display text-4xl lg:text-5xl text-charcoal leading-tight mb-3">
                {{ $product->name }}
            </h1>

            @if($product->short_description)
            <p class="text-charcoal/60 text-sm leading-relaxed mb-5">
                {{ $product->short_description }}
            </p>
            @endif

            <p class="font-display text-3xl text-walnut mb-6">{{ $product->formatted_price }}</p>

            {{-- Specs --}}
            @if($product->material || $product->dimension || $product->color)
            <div class="border-t border-b border-sand/20 py-5 mb-6 space-y-3">
                @if($product->material)
                <div class="flex gap-4">
                    <span class="text-[0.65rem] tracking-widest uppercase text-sand w-24 mt-0.5">Bahan</span>
                    <span class="text-sm text-charcoal">{{ $product->material }}</span>
                </div>
                @endif
                @if($product->dimension)
                <div class="flex gap-4">
                    <span class="text-[0.65rem] tracking-widest uppercase text-sand w-24 mt-0.5">Dimensi</span>
                    <span class="text-sm text-charcoal">{{ $product->dimension }}</span>
                </div>
                @endif
                @if($product->color)
                <div class="flex gap-4">
                    <span class="text-[0.65rem] tracking-widest uppercase text-sand w-24 mt-0.5">Warna</span>
                    <span class="text-sm text-charcoal">{{ $product->color }}</span>
                </div>
                @endif
                <div class="flex gap-4">
                    <span class="text-[0.65rem] tracking-widest uppercase text-sand w-24 mt-0.5">Stok</span>
                    <span class="text-sm {{ $product->is_in_stock ? 'text-green-700' : 'text-red-600' }}">
                        {{ $product->is_in_stock ? "Tersedia ({$product->stock} unit)" : 'Habis' }}
                    </span>
                </div>
            </div>
            @endif

            {{-- CTA --}}
            @if($product->is_in_stock)
            <a href="{{ route('order.create', ['product' => $product->slug]) }}"
               class="inline-flex items-center gap-3 w-full justify-center px-6 py-4 bg-walnut text-cream
                      text-xs tracking-widest uppercase hover:bg-walnut-dark transition-colors rounded-sm mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Pesan Sekarang
            </a>
            @else
            <div class="w-full py-4 bg-charcoal/10 text-charcoal/40 text-xs tracking-widest uppercase
                        text-center rounded-sm mb-3 cursor-not-allowed">
                Stok Habis
            </div>
            @endif

            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-2 w-full justify-center px-6 py-3.5 border border-sand/40
                      text-charcoal/60 text-xs tracking-widest uppercase hover:border-walnut hover:text-walnut
                      transition-colors rounded-sm">
                Tanya via Kontak
            </a>

            {{-- Description --}}
            @if($product->description)
            <div class="mt-8 pt-6 border-t border-sand/20">
                <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-3">Deskripsi</p>
                <div class="text-sm text-charcoal/70 leading-relaxed space-y-3">
                    @foreach(explode("\n", $product->description) as $para)
                        @if(trim($para)) <p>{{ trim($para) }}</p> @endif
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- Related Products --}}
    @if($related->isNotEmpty())
    <div class="mt-20 pt-12 border-t border-sand/20">
        <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-2">Dari Kategori yang Sama</p>
        <h2 class="font-display text-3xl text-charcoal mb-8">Produk Terkait</h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($related as $rel)
            <a href="{{ route('catalog.show', $rel->slug) }}" class="related-card bg-ivory rounded-sm overflow-hidden">
                <div class="aspect-square bg-cream overflow-hidden">
                    @if($rel->primaryImage)
                        <img src="{{ asset('storage/' . $rel->primaryImage->path) }}"
                             alt="{{ $rel->name }}" class="w-full h-full object-cover" loading="lazy">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-sand/30 font-display text-2xl italic">foto</div>
                    @endif
                </div>
                <div class="p-3">
                    <h3 class="font-display text-base text-charcoal leading-tight mb-1">{{ $rel->name }}</h3>
                    <p class="text-walnut text-sm font-medium">{{ $rel->formatted_price }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

</div>

@endsection

@push('scripts')
<script>
    function setImage(src, btn) {
        const img = document.getElementById('main-img');
        img.style.opacity = '0';
        setTimeout(() => { img.src = src; img.style.opacity = '1'; }, 200);
        document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');
    }
</script>
@endpush