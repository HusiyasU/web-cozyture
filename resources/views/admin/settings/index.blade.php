@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('breadcrumb', 'Pengaturan')

@push('styles')
<style>
    .form-label { display:block; font-size:0.68rem; letter-spacing:0.08em; text-transform:uppercase; color:#A8967A; margin-bottom:5px; }
    .form-input { width:100%; padding:9px 12px; background:white; border:1px solid rgba(201,185,154,0.4); border-radius:6px; font-family:"DM Sans",sans-serif; font-size:0.875rem; color:#2C2825; transition:border-color 0.2s,box-shadow 0.2s; outline:none; }
    .form-input:focus { border-color:#5C3D2E; box-shadow:0 0 0 3px rgba(92,61,46,0.07); }
    .form-input::placeholder { color:#C9B99A; }
</style>
@endpush

@section('content')

<div class="mb-6">
    <h2 class="font-display text-2xl text-charcoal">Pengaturan Toko</h2>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf

    <div class="grid lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-5">

            {{-- Info Toko --}}
            <div class="admin-card p-5 space-y-4">
                <p class="text-[0.65rem] tracking-widest uppercase text-sand">Informasi Toko</p>

                <div>
                    <label class="form-label" for="store_name">Nama Toko *</label>
                    <input type="text" name="store_name" id="store_name"
                           value="{{ old('store_name', $settings['store_name'] ?? 'Cozyture') }}"
                           class="form-input @error('store_name') border-red-300 @enderror">
                    @error('store_name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="form-label" for="store_tagline">Tagline</label>
                    <input type="text" name="store_tagline" id="store_tagline"
                           value="{{ old('store_tagline', $settings['store_tagline'] ?? '') }}"
                           placeholder="Furniture & Living"
                           class="form-input">
                </div>

                <div>
                    <label class="form-label" for="store_description">Deskripsi Toko</label>
                    <textarea name="store_description" id="store_description" rows="3"
                              class="form-input">{{ old('store_description', $settings['store_description'] ?? '') }}</textarea>
                </div>
            </div>

            {{-- Kontak --}}
            <div class="admin-card p-5 space-y-4">
                <p class="text-[0.65rem] tracking-widest uppercase text-sand">Kontak</p>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label" for="store_phone">Nomor Telepon</label>
                        <input type="text" name="store_phone" id="store_phone"
                               value="{{ old('store_phone', $settings['store_phone'] ?? '') }}"
                               placeholder="+62 812-xxxx-xxxx"
                               class="form-input @error('store_phone') border-red-300 @enderror">
                    </div>
                    <div>
                        <label class="form-label" for="store_email">Email</label>
                        <input type="email" name="store_email" id="store_email"
                               value="{{ old('store_email', $settings['store_email'] ?? '') }}"
                               placeholder="hello@cozyture.id"
                               class="form-input @error('store_email') border-red-300 @enderror">
                        @error('store_email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="form-label" for="store_address">Alamat</label>
                    <textarea name="store_address" id="store_address" rows="2"
                              class="form-input">{{ old('store_address', $settings['store_address'] ?? '') }}</textarea>
                </div>

                <div>
                    <label class="form-label" for="store_maps_url">URL Google Maps</label>
                    <input type="text" name="store_maps_url" id="store_maps_url"
                           value="{{ old('store_maps_url', $settings['store_maps_url'] ?? '') }}"
                           placeholder="https://maps.google.com/..."
                           class="form-input">
                </div>
            </div>

            {{-- Sosial Media --}}
            <div class="admin-card p-5 space-y-4">
                <p class="text-[0.65rem] tracking-widest uppercase text-sand">Sosial Media</p>

                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="form-label" for="social_whatsapp">WhatsApp</label>
                        <input type="text" name="social_whatsapp" id="social_whatsapp"
                               value="{{ old('social_whatsapp', $settings['social_whatsapp'] ?? '') }}"
                               placeholder="628123456789"
                               class="form-input">
                        <p class="text-xs text-charcoal/40 mt-1">Format: 628xxx (tanpa +)</p>
                    </div>
                    <div>
                        <label class="form-label" for="social_instagram">Instagram</label>
                        <input type="text" name="social_instagram" id="social_instagram"
                               value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}"
                               placeholder="@cozyture.id"
                               class="form-input">
                    </div>
                    <div>
                        <label class="form-label" for="social_facebook">Facebook</label>
                        <input type="text" name="social_facebook" id="social_facebook"
                               value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}"
                               placeholder="Cozyture"
                               class="form-input">
                    </div>
                </div>
            </div>

        </div>

        <div class="space-y-5">

            {{-- SEO --}}
            <div class="admin-card p-5 space-y-4">
                <p class="text-[0.65rem] tracking-widest uppercase text-sand">SEO</p>

                <div>
                    <label class="form-label" for="meta_title">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title"
                           value="{{ old('meta_title', $settings['meta_title'] ?? '') }}"
                           class="form-input">
                </div>

                <div>
                    <label class="form-label" for="meta_description">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="3"
                              class="form-input">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                </div>
            </div>

            {{-- Katalog --}}
            <div class="admin-card p-5 space-y-4">
                <p class="text-[0.65rem] tracking-widest uppercase text-sand">Katalog</p>
                <div>
                    <label class="form-label" for="products_per_page">Produk per Halaman</label>
                    <select name="products_per_page" id="products_per_page" class="form-input cursor-pointer">
                        @foreach([4, 8, 12, 16, 24, 36, 48] as $n)
                        <option value="{{ $n }}" {{ ($settings['products_per_page'] ?? 12) == $n ? 'selected' : '' }}>
                            {{ $n }} produk
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit"
                    class="w-full py-3 bg-walnut text-cream text-xs tracking-widest uppercase rounded-sm hover:bg-walnut-dark transition-colors">
                Simpan Pengaturan
            </button>

        </div>
    </div>
</form>

@endsection
