@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('breadcrumb', 'Edit Produk')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h2 class="font-display text-2xl text-charcoal">Edit: {{ $product->name }}</h2>
    <a href="{{ route('catalog.show', $product->slug) }}" target="_blank"
       class="text-xs text-charcoal/40 hover:text-walnut transition-colors flex items-center gap-1">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
        </svg>
        Lihat di website
    </a>
</div>

<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.products._form')
</form>

@endsection
