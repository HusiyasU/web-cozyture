@extends('layouts.app')

@section('title', 'Pesan Sekarang')
@section('meta_description', 'Isi form pemesanan furnitur Cozyture dan tim kami akan segera menghubungi kamu.')

@push('styles')
<style>
    .form-label {
        display: block;
        font-size: 0.7rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #A8967A;
        margin-bottom: 6px;
    }
    .form-input {
        width: 100%;
        padding: 10px 14px;
        background: white;
        border: 1px solid rgba(201,185,154,0.4);
        border-radius: 4px;
        font-family: "DM Sans", sans-serif;
        font-size: 0.875rem;
        color: #2C2825;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
    }
    .form-input:focus {
        border-color: #5C3D2E;
        box-shadow: 0 0 0 3px rgba(92,61,46,0.07);
    }
    .form-input.error { border-color: #dc2626; }
    .form-input::placeholder { color: #C9B99A; }
    select.form-input { cursor: pointer; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23C9B99A'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px; padding-right: 36px; }
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="bg-cream-dark border-b border-sand/20 py-10">
    <div class="max-w-3xl mx-auto px-6 lg:px-12">
        <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-1">Cozyture</p>
        <h1 class="font-display text-4xl text-charcoal">Pesan Sekarang</h1>
        <p class="text-sm text-charcoal/50 mt-2">
            Isi form di bawah dan tim kami akan menghubungi kamu dalam 1x24 jam.
        </p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-6 lg:px-12 py-12">
    <div class="grid lg:grid-cols-5 gap-10">

        {{-- ===== FORM ===== --}}
        <form method="POST" action="{{ route('order.store') }}" class="lg:col-span-3 space-y-5">
            @csrf

            {{-- Pilih Produk --}}
            <div>
                <label class="form-label" for="product_id">Produk yang Dipesan *</label>
                <select name="product_id" id="product_id"
                        class="form-input @error('product_id') error @enderror"
                        onchange="updateProductInfo(this)">
                    <option value="">— Pilih Produk —</option>
                    @foreach($products->groupBy('category.name') as $catName => $catProducts)
                    <optgroup label="{{ $catName }}">
                        @foreach($catProducts as $p)
                        <option value="{{ $p->id }}"
                                data-price="{{ $p->formatted_price }}"
                                data-material="{{ $p->material }}"
                                data-dimension="{{ $p->dimension }}"
                                {{ old('product_id', $selectedProduct?->id) == $p->id ? 'selected' : '' }}>
                            {{ $p->name }}
                        </option>
                        @endforeach
                    </optgroup>
                    @endforeach
                </select>
                @error('product_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Info produk terpilih --}}
            <div id="product-info" class="hidden bg-cream rounded-sm p-4 text-sm space-y-1.5">
                <p class="text-[0.6rem] tracking-widest uppercase text-sand">Detail Produk</p>
                <p class="font-medium text-charcoal" id="info-price"></p>
                <p class="text-charcoal/50" id="info-material"></p>
                <p class="text-charcoal/50" id="info-dimension"></p>
            </div>

            {{-- Jumlah --}}
            <div>
                <label class="form-label" for="quantity">Jumlah *</label>
                <input type="number" name="quantity" id="quantity"
                       value="{{ old('quantity', 1) }}" min="1" max="100"
                       class="form-input @error('quantity') error @enderror">
                @error('quantity')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <hr class="border-sand/20">

            {{-- Nama --}}
            <div>
                <label class="form-label" for="customer_name">Nama Lengkap *</label>
                <input type="text" name="customer_name" id="customer_name"
                       value="{{ old('customer_name') }}" placeholder="Nama lengkap kamu"
                       class="form-input @error('customer_name') error @enderror">
                @error('customer_name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="form-label" for="customer_email">Email *</label>
                <input type="email" name="customer_email" id="customer_email"
                       value="{{ old('customer_email') }}" placeholder="email@kamu.com"
                       class="form-input @error('customer_email') error @enderror">
                @error('customer_email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Telepon --}}
            <div>
                <label class="form-label" for="customer_phone">Nomor Telepon / WhatsApp *</label>
                <input type="tel" name="customer_phone" id="customer_phone"
                       value="{{ old('customer_phone') }}" placeholder="08xxxxxxxxxx"
                       class="form-input @error('customer_phone') error @enderror">
                @error('customer_phone')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Alamat --}}
            <div>
                <label class="form-label" for="customer_address">Alamat Pengiriman *</label>
                <textarea name="customer_address" id="customer_address" rows="3"
                          placeholder="Jl. Nama Jalan No. XX, Kelurahan, Kecamatan, Kota, Provinsi"
                          class="form-input @error('customer_address') error @enderror">{{ old('customer_address') }}</textarea>
                @error('customer_address')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Catatan --}}
            <div>
                <label class="form-label" for="notes">Catatan Tambahan</label>
                <textarea name="notes" id="notes" rows="3"
                          placeholder="Warna pilihan, ukuran custom, atau permintaan khusus lainnya..."
                          class="form-input">{{ old('notes') }}</textarea>
            </div>

            <button type="submit"
                    class="w-full py-4 bg-walnut text-cream text-xs tracking-widest uppercase
                           hover:bg-walnut-dark transition-colors rounded-sm">
                Kirim Pesanan
            </button>

            <p class="text-xs text-center text-charcoal/40">
                Dengan mengirim form ini kamu menyetujui untuk dihubungi oleh tim Cozyture.
            </p>
        </form>

        {{-- ===== SIDEBAR INFO ===== --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-cream rounded-sm p-5">
                <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-4">Proses Pemesanan</p>
                <ol class="space-y-4">
                    @foreach([
                        ['Isi Form', 'Lengkapi data diri dan pilih produk yang kamu inginkan.'],
                        ['Konfirmasi', 'Tim kami menghubungi kamu dalam 1x24 jam untuk konfirmasi detail.'],
                        ['Pembayaran', 'Lakukan pembayaran sesuai instruksi dari tim kami.'],
                        ['Pengiriman', 'Produk dikirimkan ke alamat kamu.'],
                    ] as $i => $step)
                    <li class="flex gap-3">
                        <span class="w-6 h-6 rounded-full bg-walnut/10 text-walnut text-xs font-medium
                                     flex items-center justify-center shrink-0 mt-0.5">{{ $i+1 }}</span>
                        <div>
                            <p class="text-sm font-medium text-charcoal">{{ $step[0] }}</p>
                            <p class="text-xs text-charcoal/50 leading-relaxed">{{ $step[1] }}</p>
                        </div>
                    </li>
                    @endforeach
                </ol>
            </div>

            <div class="bg-cream rounded-sm p-5">
                <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-3">Butuh Bantuan?</p>
                <p class="text-sm text-charcoal/60 mb-3">Hubungi kami langsung via WhatsApp atau email.</p>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('social_whatsapp', '6281234567890')) }}"
                   target="_blank"
                   class="flex items-center gap-2 text-sm text-walnut hover:text-walnut-dark transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    Chat WhatsApp
                </a>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    function updateProductInfo(select) {
        const opt = select.options[select.selectedIndex];
        const box = document.getElementById('product-info');
        if (! opt.value) { box.classList.add('hidden'); return; }
        document.getElementById('info-price').textContent     = opt.dataset.price     || '';
        document.getElementById('info-material').textContent  = opt.dataset.material  ? 'Bahan: ' + opt.dataset.material   : '';
        document.getElementById('info-dimension').textContent = opt.dataset.dimension ? 'Dimensi: ' + opt.dataset.dimension : '';
        box.classList.remove('hidden');
    }

    // Trigger on load jika ada pre-selected
    window.addEventListener('DOMContentLoaded', () => {
        const sel = document.getElementById('product_id');
        if (sel.value) updateProductInfo(sel);
    });
</script>
@endpush