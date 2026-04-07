@extends('layouts.admin')

@section('title', 'Kategori')
@section('breadcrumb', 'Kategori')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="font-display text-2xl text-charcoal">Kategori</h2>
        <p class="text-xs text-charcoal/40 mt-0.5">{{ $categories->count() }} kategori</p>
    </div>
    <a href="{{ route('admin.categories.create') }}"
       class="px-4 py-2.5 bg-walnut text-cream text-xs tracking-widest uppercase rounded-sm hover:bg-walnut-dark transition-colors">
        + Tambah Kategori
    </a>
</div>

<div class="admin-card overflow-hidden">
    <table class="admin-table w-full">
        <thead>
            <tr>
                <th class="text-left w-12"></th>
                <th class="text-left">Nama</th>
                <th class="text-left">Slug</th>
                <th class="text-left">Produk</th>
                <th class="text-left">Status</th>
                <th class="text-left">Urutan</th>
                <th class="text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td>
                    <div class="w-10 h-10 rounded-sm overflow-hidden bg-cream">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-sand/40 text-xs">foto</div>
                        @endif
                    </div>
                </td>
                <td>
                    <p class="font-medium text-charcoal text-sm">{{ $category->name }}</p>
                    @if($category->description)
                    <p class="text-xs text-charcoal/40 truncate max-w-xs">{{ $category->description }}</p>
                    @endif
                </td>
                <td class="text-xs text-charcoal/40 font-mono">{{ $category->slug }}</td>
                <td class="text-sm">{{ $category->products_count }}</td>
                <td>
                    @if($category->is_active)
                        <span class="badge bg-green-100 text-green-700">Aktif</span>
                    @else
                        <span class="badge bg-gray-100 text-gray-500">Nonaktif</span>
                    @endif
                </td>
                <td class="text-sm text-charcoal/50">{{ $category->sort_order }}</td>
                <td class="text-right">
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="text-xs text-walnut hover:underline">Edit</a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                              onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-500 hover:underline">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-12 text-charcoal/30 italic text-sm">Belum ada kategori</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
