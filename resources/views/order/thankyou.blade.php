@extends('layouts.app')

@section('title', 'Pesanan Diterima')

@push('styles')
<style>
    @keyframes checkIn {
        from { transform: scale(0.5); opacity: 0; }
        to   { transform: scale(1);   opacity: 1; }
    }
    @keyframes fadeUp {
        from { transform: translateY(20px); opacity: 0; }
        to   { transform: translateY(0);    opacity: 1; }
    }
    .check-anim  { animation: checkIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s both; }
    .fade-up-1   { animation: fadeUp 0.5s ease 0.5s both; }
    .fade-up-2   { animation: fadeUp 0.5s ease 0.65s both; }
    .fade-up-3   { animation: fadeUp 0.5s ease 0.8s both; }
</style>
@endpush

@section('content')

<div class="min-h-[80vh] flex items-center justify-center px-6 py-16">
    <div class="max-w-lg w-full text-center">

        {{-- Check Icon --}}
        <div class="check-anim inline-flex items-center justify-center w-20 h-20 rounded-full bg-walnut/10 mb-6">
            <svg class="w-9 h-9 text-walnut" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <div class="fade-up-1">
            <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-2">Terima Kasih</p>
            <h1 class="font-display text-4xl lg:text-5xl text-charcoal mb-3">
                Pesanan kamu diterima!
            </h1>
            <p class="text-charcoal/50 text-sm leading-relaxed mb-8">
                Tim Cozyture akan menghubungi kamu dalam <strong class="text-charcoal">1x24 jam</strong>
                untuk konfirmasi detail pesanan.
            </p>
        </div>

        {{-- Order Detail Card --}}
        <div class="fade-up-2 bg-cream rounded-sm p-6 text-left mb-8">
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-sand/20">
                <p class="text-[0.6rem] tracking-widest uppercase text-sand">Nomor Pesanan</p>
                <p class="font-medium text-charcoal text-sm">{{ $order->order_number }}</p>
            </div>

            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-charcoal/50">Produk</span>
                    <span class="text-charcoal text-right max-w-[200px]">{{ $order->product->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-charcoal/50">Jumlah</span>
                    <span class="text-charcoal">{{ $order->quantity }} unit</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-charcoal/50">Nama</span>
                    <span class="text-charcoal">{{ $order->customer_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-charcoal/50">Email</span>
                    <span class="text-charcoal">{{ $order->customer_email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-charcoal/50">Telepon</span>
                    <span class="text-charcoal">{{ $order->customer_phone }}</span>
                </div>
                <div class="flex justify-between gap-4">
                    <span class="text-charcoal/50 shrink-0">Alamat</span>
                    <span class="text-charcoal text-right">{{ $order->customer_address }}</span>
                </div>
                @if($order->notes)
                <div class="flex justify-between gap-4">
                    <span class="text-charcoal/50 shrink-0">Catatan</span>
                    <span class="text-charcoal text-right">{{ $order->notes }}</span>
                </div>
                @endif
            </div>

            <div class="mt-4 pt-4 border-t border-sand/20">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-orange-400"></span>
                    <span class="text-xs text-charcoal/50">Status: Menunggu konfirmasi</span>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="fade-up-3 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('catalog.index') }}"
               class="px-6 py-3 bg-walnut text-cream text-xs tracking-widest uppercase
                      hover:bg-walnut-dark transition-colors rounded-sm">
                Lanjut Belanja
            </a>
            <a href="{{ route('home') }}"
               class="px-6 py-3 border border-sand/40 text-charcoal text-xs tracking-widest uppercase
                      hover:border-walnut hover:text-walnut transition-colors rounded-sm">
                Ke Beranda
            </a>
        </div>

    </div>
</div>

@endsection