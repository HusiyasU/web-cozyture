@extends('layouts.admin')

@section('title', isset($category) ? 'Edit Kategori' : 'Tambah Kategori')
@section('breadcrumb', isset($category) ? 'Edit Kategori' : 'Tambah Kategori')

@push('styles')
<style>
    .form-label { display:block; font-size:0.68rem; letter-spacing:0.08em; text-transform:uppercase; color:#A8967A; margin-bottom:5px; }
    .form-input { width:100%; padding:9px 12px; background:white; border:1px solid rgba(201,185,154,0.4); border-radius:6px; font-family:"DM Sans",sans-serif; font-size:0.875rem; color:#2C2825; transition:border-color 0.2s,box-shadow 0.2s; outline:none; }
    .form-input:focus { border-color:#5C3D2E; box-shadow:0 0 0 3px rgba(92,61,46,0.07); }
    .form-input.error { border-color:#dc2626; }
    .form-input::placeholder { color:#C9B99A; }
</style>
@endpush

@section('content')

<div class="mb-6">
    <h2 class="font-display text-2xl text-charcoal">
        {{ isset($category) ? 'Edit: ' . $category->name : 'Tambah Kategori Baru' }}
    </h2>
</div>

<form method="POST"
      action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if(isset($category)) @method('PUT') @endif

    <div class="grid lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-5">
            <div class="admin-card p-5 space-y-5">

                <div>
                    <label class="form-label" for="name">Nama Kategori *</label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', $category->name ?? '') }}"
                           placeholder="Contoh: Sofa & Kursi"
                           class="form-input @error('name') error @enderror">
                    @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="form-label" for="slug">Slug</label>
                    <input type="text" name="slug" id="slug"
                           value="{{ old('slug', $category->slug ?? '') }}"
                           placeholder="otomatis dari nama"
                           class="form-input @error('slug') error @enderror">
                    @error('slug')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                              placeholder="Deskripsi singkat kategori..."
                              class="form-input">{{ old('description', $category->description ?? '') }}</textarea>
                </div>

                <div>
                    <label class="form-label">Gambar Kategori</label>
                    @if(isset($category) && $category->image)
                    <div class="mb-3 w-24 h-24 rounded-sm overflow-hidden bg-cream">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <input type="file" name="image" accept="image/*"
                           class="block w-full text-sm text-charcoal/60 file:mr-4 file:py-2 file:px-4 file:rounded-sm file:border-0 file:text-xs file:bg-walnut/10 file:text-walnut hover:file:bg-walnut/20 file:cursor-pointer">
                    <p class="mt-1.5 text-xs text-charcoal/40">JPG, PNG, WEBP. Maks. 2MB.</p>
                </div>

            </div>
        </div>

        <div class="space-y-5">
            <div class="admin-card p-5 space-y-4">
                <p class="text-[0.65rem] tracking-widest uppercase text-sand">Pengaturan</p>

                <div>
                    <label class="form-label" for="sort_order">Urutan Tampil</label>
                    <input type="number" name="sort_order" id="sort_order" min="0"
                           value="{{ old('sort_order', $category->sort_order ?? 0) }}"
                           class="form-input">
                </div>

                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           style="accent-color:#5C3D2E; width:18px; height:18px; cursor:pointer;"
                           {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                    <label for="is_active" class="text-sm text-charcoal cursor-pointer">Kategori Aktif</label>
                </div>
            </div>

            <div class="flex flex-col gap-3">
                <button type="submit"
                        class="w-full py-3 bg-walnut text-cream text-xs tracking-widest uppercase rounded-sm hover:bg-walnut-dark transition-colors">
                    {{ isset($category) ? 'Simpan Perubahan' : 'Tambah Kategori' }}
                </button>
                <a href="{{ route('admin.categories.index') }}"
                   class="w-full py-3 text-center border border-sand/30 text-charcoal/60 text-xs tracking-widest uppercase rounded-sm hover:border-walnut hover:text-walnut transition-colors">
                    Batal
                </a>
            </div>
        </div>

    </div>
</form>

@endsection
