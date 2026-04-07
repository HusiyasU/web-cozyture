@extends('layouts.admin')

@section('title', 'Produk')
@section('breadcrumb', 'Produk')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="font-display text-2xl text-charcoal">Daftar Produk</h2>
        <p class="text-xs text-charcoal/40 mt-0.5">{{ $products->total() }} produk total</p>
    </div>
    <a href="{{ route('admin.products.create') }}"
       class="px-4 py-2.5 bg-walnut text-cream text-xs tracking-widest uppercase rounded-sm hover:bg-walnut-dark transition-colors">
        + Tambah Produk
    </a>
</div>

{{-- Filter --}}
<div class="admin-card p-4 mb-5">
    <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
               class="flex-1 min-w-48 px-3 py-2 text-sm border border-sand/30 rounded-sm bg-white focus:outline-none focus:border-walnut text-charcoal">
        <select name="category" class="px-3 py-2 text-sm border border-sand/30 rounded-sm bg-white focus:outline-none focus:border-walnut text-charcoal">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <select name="status" class="px-3 py-2 text-sm border border-sand/30 rounded-sm bg-white focus:outline-none focus:border-walnut text-charcoal">
            <option value="">Semua Status</option>
            <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            <option value="featured" {{ request('status') === 'featured' ? 'selected' : '' }}>Unggulan</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-walnut/10 text-walnut text-sm rounded-sm hover:bg-walnut/20 transition-colors">Cari</button>
        @if(request()->hasAny(['search','category','status']))
        <a href="{{ route('admin.products.index') }}" class="px-4 py-2 text-sm text-charcoal/50 hover:text-charcoal transition-colors">Reset</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="admin-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead>
                <tr>
                    <th class="text-left w-12"></th>
                    <th class="text-left">Produk</th>
                    <th class="text-left">Kategori</th>
                    <th class="text-left">Harga</th>
                    <th class="text-left">Stok</th>
                    <th class="text-left">Status</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <div class="w-10 h-10 rounded-sm overflow-hidden bg-cream shrink-0">
                            @if($product->primaryImage)
                                <img src="{{ asset('storage/' . $product->primaryImage->path) }}"
                                     alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-sand/40 text-xs">foto</div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <p class="font-medium text-charcoal text-sm">{{ $product->name }}</p>
                        <p class="text-xs text-charcoal/40">{{ $product->material }}</p>
                    </td>
                    <td class="text-sm">{{ $product->category->name ?? '-' }}</td>
                    <td class="text-sm">{{ $product->formatted_price }}</td>
                    <td>
                        <span class="text-sm {{ $product->stock <= 0 ? 'text-red-500' : ($product->stock <= 3 ? 'text-orange-500' : 'text-charcoal') }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td>
                        <div class="flex gap-1.5 flex-wrap">
                            @if($product->is_active)
                                <span class="badge bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="badge bg-gray-100 text-gray-500">Nonaktif</span>
                            @endif
                            @if($product->is_featured)
                                <span class="badge bg-amber-100 text-amber-700">Unggulan</span>
                            @endif
                        </div>
                    </td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="text-xs text-walnut hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-red-500 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-charcoal/30 italic text-sm">Belum ada produk</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="px-5 py-3 border-t border-sand/20 flex justify-end">
        {{ $products->links('vendor.pagination.cozyture') }}
    </div>
    @endif
</div>

@endsection
