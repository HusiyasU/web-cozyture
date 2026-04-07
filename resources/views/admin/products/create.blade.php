@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('breadcrumb', 'Tambah Produk')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h2 class="font-display text-2xl text-charcoal">Tambah Produk Baru</h2>
</div>

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.products._form')
</form>

@endsection
