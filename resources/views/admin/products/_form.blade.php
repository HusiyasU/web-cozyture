{{--
    Partial form untuk create & edit produk.
    Variabel: $product (opsional, untuk edit), $categories
--}}

@push('styles')
<style>
    .form-label {
        display: block;
        font-size: 0.68rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #A8967A;
        margin-bottom: 5px;
    }
    .form-input {
        width: 100%;
        padding: 9px 12px;
        background: white;
        border: 1px solid rgba(201,185,154,0.4);
        border-radius: 6px;
        font-family: "DM Sans", sans-serif;
        font-size: 0.875rem;
        color: #2C2825;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
    }
    .form-input:focus { border-color: #5C3D2E; box-shadow: 0 0 0 3px rgba(92,61,46,0.07); }
    .form-input.error { border-color: #dc2626; }
    .form-input::placeholder { color: #C9B99A; }
    select.form-input { cursor: pointer; }
    .toggle-wrap { display: flex; align-items: center; gap: 10px; }
    .toggle-wrap input[type=checkbox] { width: 36px; height: 20px; accent-color: #5C3D2E; cursor: pointer; }
</style>
@endpush

<div class="grid lg:grid-cols-3 gap-6">

    {{-- Left: Main Info --}}
    <div class="lg:col-span-2 space-y-5">

        <div class="admin-card p-5 space-y-5">
            <p class="text-[0.65rem] tracking-widest uppercase text-sand">Informasi Produk</p>

            <div>
                <label class="form-label" for="name">Nama Produk *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}"
                       placeholder="Contoh: Sofa Minimalis 3 Dudukan"
                       class="form-input @error('name') error @enderror">
                @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="form-label" for="slug">Slug (URL)</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug ?? '') }}"
                       placeholder="otomatis dari nama jika dikosongkan"
                       class="form-input @error('slug') error @enderror">
                @error('slug')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="form-label" for="short_description">Deskripsi Singkat</label>
                <input type="text" name="short_description" id="short_description"
                       value="{{ old('short_description', $product->short_description ?? '') }}"
                       placeholder="Maks. 300 karakter, tampil di kartu katalog"
                       class="form-input @error('short_description') error @enderror">
                @error('short_description')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="form-label" for="description">Deskripsi Lengkap</label>
                <textarea name="description" id="description" rows="5"
                          placeholder="Deskripsi detail produk..."
                          class="form-input @error('description') error @enderror">{{ old('description', $product->description ?? '') }}</textarea>
                @error('description')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="admin-card p-5 space-y-5">
            <p class="text-[0.65rem] tracking-widets uppercase text-sand">Spesifikasi</p>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="form-label" for="material">Bahan / Material</label>
                    <input type="text" name="material" id="material"
                           value="{{ old('material', $product->material ?? '') }}"
                           placeholder="Kayu Jati, Rotan, MDF..."
                           class="form-input">
                </div>
                <div>
                    <label class="form-label" for="color">Warna</label>
                    <input type="text" name="color" id="color"
                           value="{{ old('color', $product->color ?? '') }}"
                           placeholder="Natural, Walnut, Putih..."
                           class="form-input">
                </div>
                <div>
                    <label class="form-label" for="dimension">Dimensi</label>
                    <input type="text" name="dimension" id="dimension"
                           value="{{ old('dimension', $product->dimension ?? '') }}"
                           placeholder="P x L x T cm"
                           class="form-input">
                </div>
                <div>
                    <label class="form-label" for="stock">Stok *</label>
                    <input type="number" name="stock" id="stock" min="0"
                           value="{{ old('stock', $product->stock ?? 0) }}"
                           class="form-input @error('stock') error @enderror">
                    @error('stock')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Upload Gambar Baru --}}
        <div class="admin-card p-5">
            <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-4">
                {{ isset($product) ? 'Tambah Gambar Baru' : 'Upload Gambar' }}
            </p>
            <input type="file" name="images[]" multiple accept="image/*"
                   class="block w-full text-sm text-charcoal/60
                          file:mr-4 file:py-2 file:px-4 file:rounded-sm file:border-0
                          file:text-xs file:bg-walnut/10 file:text-walnut
                          hover:file:bg-walnut/20 file:cursor-pointer file:transition-colors">
            <p class="mt-2 text-xs text-charcoal/40">JPG, PNG, WEBP. Maks. 3MB per file. Gambar pertama jadi foto utama.</p>
            @error('images.*')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>

        {{-- Existing Images (Edit mode) --}}
        @if(isset($product) && $product->images->isNotEmpty())
        <div class="admin-card p-5">
            <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-4">Gambar Saat Ini</p>
            <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                @foreach($product->images as $image)
                <div class="relative group">
                    <div class="aspect-square rounded-sm overflow-hidden bg-cream {{ $image->is_primary ? 'ring-2 ring-walnut' : '' }}">
                        <img src="{{ asset('storage/' . $image->path) }}"
                             alt="{{ $image->alt }}" class="w-full h-full object-cover">
                    </div>
                    @if($image->is_primary)
                    <span class="absolute top-1 left-1 bg-walnut text-cream text-[0.55rem] px-1.5 py-0.5 rounded">Utama</span>
                    @endif
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-sm flex items-center justify-center gap-2">
                        @if(! $image->is_primary)
                        <form method="POST" action="{{ route('admin.products.images.primary', [$product, $image]) }}">
                            @csrf @method('PATCH')
                            <button type="submit" title="Jadikan utama"
                                    class="text-white text-xs bg-walnut/80 px-2 py-1 rounded hover:bg-walnut transition-colors">
                                Utama
                            </button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('admin.products.images.delete', [$product, $image]) }}"
                              onsubmit="return confirm('Hapus gambar ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" title="Hapus"
                                    class="text-white text-xs bg-red-600/80 px-2 py-1 rounded hover:bg-red-600 transition-colors">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    {{-- Right: Meta --}}
    <div class="space-y-5">

        <div class="admin-card p-5 space-y-5">
            <p class="text-[0.65rem] tracking-widest uppercase text-sand">Harga & Kategori</p>

            <div>
                <label class="form-label" for="price">Harga (Rp) *</label>
                <input type="number" name="price" id="price" min="0" step="1000"
                       value="{{ old('price', $product->price ?? '') }}"
                       placeholder="0"
                       class="form-input @error('price') error @enderror">
                @error('price')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="form-label" for="category_id">Kategori *</label>
                <select name="category_id" id="category_id"
                        class="form-input @error('category_id') error @enderror">
                    <option value="">— Pilih Kategori —</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                            {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="form-label" for="sort_order">Urutan Tampil</label>
                <input type="number" name="sort_order" id="sort_order" min="0"
                       value="{{ old('sort_order', $product->sort_order ?? 0) }}"
                       class="form-input">
            </div>
        </div>

        <div class="admin-card p-5 space-y-4">
            <p class="text-[0.65rem] tracking-widest uppercase text-sand">Visibilitas</p>

            <div class="toggle-wrap">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                       {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                <label for="is_active" class="text-sm text-charcoal cursor-pointer">Produk Aktif</label>
            </div>

            <div class="toggle-wrap">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" id="is_featured" value="1"
                       {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                <label for="is_featured" class="text-sm text-charcoal cursor-pointer">Tampilkan sebagai Unggulan</label>
            </div>
        </div>

        <div class="flex flex-col gap-3">
            <button type="submit"
                    class="w-full py-3 bg-walnut text-cream text-xs tracking-widest uppercase rounded-sm hover:bg-walnut-dark transition-colors">
                {{ isset($product) ? 'Simpan Perubahan' : 'Tambah Produk' }}
            </button>
            <a href="{{ route('admin.products.index') }}"
               class="w-full py-3 text-center border border-sand/30 text-charcoal/60 text-xs tracking-widest uppercase rounded-sm hover:border-walnut hover:text-walnut transition-colors">
                Batal
            </a>
        </div>

    </div>
</div>
