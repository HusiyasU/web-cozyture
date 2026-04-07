@extends('layouts.app')

@section('title', 'Kontak')
@section('meta_description', 'Hubungi tim Cozyture — kami siap membantu kamu menemukan furnitur yang tepat.')

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
    .reveal { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .reveal.visible { opacity: 1; transform: none; }
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="bg-cream-dark border-b border-sand/20 py-10">
    <div class="max-w-4xl mx-auto px-6 lg:px-12">
        <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-1">Cozyture</p>
        <h1 class="font-display text-4xl text-charcoal">Hubungi Kami</h1>
        <p class="text-sm text-charcoal/50 mt-2">
            Ada pertanyaan? Kami dengan senang hati membantu kamu.
        </p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-6 lg:px-12 py-14">
    <div class="grid lg:grid-cols-5 gap-12">

        {{-- ===== FORM ===== --}}
        <div class="lg:col-span-3 reveal">

            @if(session('success'))
            <div class="mb-6 px-5 py-4 bg-walnut/10 border border-walnut/20 rounded-sm">
                <p class="text-sm text-walnut">{{ session('success') }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('contact.send') }}" class="space-y-5">
                @csrf

                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label" for="name">Nama Lengkap *</label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name') }}" placeholder="Nama kamu"
                               class="form-input @error('name') error @enderror">
                        @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label" for="email">Email *</label>
                        <input type="email" name="email" id="email"
                               value="{{ old('email') }}" placeholder="email@kamu.com"
                               class="form-input @error('email') error @enderror">
                        @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="form-label" for="phone">Nomor Telepon</label>
                    <input type="tel" name="phone" id="phone"
                           value="{{ old('phone') }}" placeholder="08xxxxxxxxxx (opsional)"
                           class="form-input">
                </div>

                <div>
                    <label class="form-label" for="message">Pesan *</label>
                    <textarea name="message" id="message" rows="5"
                              placeholder="Tuliskan pertanyaan atau kebutuhanmu di sini..."
                              class="form-input @error('message') error @enderror">{{ old('message') }}</textarea>
                    @error('message')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <button type="submit"
                        class="w-full py-4 bg-walnut text-cream text-xs tracking-widest uppercase
                               hover:bg-walnut-dark transition-colors rounded-sm">
                    Kirim Pesan
                </button>
            </form>
        </div>

        {{-- ===== INFO KONTAK ===== --}}
        <div class="lg:col-span-2 space-y-6 reveal" style="transition-delay:.15s">

            <div>
                <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-5">Informasi Kontak</p>
                <div class="space-y-4">
                    @if($settings['store_phone'] ?? null)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-walnut/10 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-walnut" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[0.6rem] tracking-widest uppercase text-sand mb-0.5">Telepon</p>
                            <p class="text-sm text-charcoal">{{ $settings['store_phone'] }}</p>
                        </div>
                    </div>
                    @endif

                    @if($settings['store_email'] ?? null)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-walnut/10 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-walnut" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[0.6rem] tracking-widest uppercase text-sand mb-0.5">Email</p>
                            <p class="text-sm text-charcoal">{{ $settings['store_email'] }}</p>
                        </div>
                    </div>
                    @endif

                    @if($settings['store_address'] ?? null)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-walnut/10 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-walnut" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[0.6rem] tracking-widest uppercase text-sand mb-0.5">Alamat</p>
                            <p class="text-sm text-charcoal leading-relaxed">{{ $settings['store_address'] }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- WhatsApp CTA --}}
            @if($settings['social_whatsapp'] ?? null)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['social_whatsapp']) }}"
               target="_blank"
               class="flex items-center gap-3 w-full px-5 py-4 bg-[#25D366]/10 border border-[#25D366]/30
                      rounded-sm hover:bg-[#25D366]/20 transition-colors group">
                <svg class="w-5 h-5 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-charcoal">Chat via WhatsApp</p>
                    <p class="text-xs text-charcoal/50">Respons cepat di jam kerja</p>
                </div>
                <svg class="w-4 h-4 text-charcoal/30 ml-auto group-hover:text-charcoal/60 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            @endif

            {{-- Jam operasional --}}
            <div class="bg-cream rounded-sm p-5">
                <p class="text-[0.6rem] tracking-widest uppercase text-sand mb-3">Jam Operasional</p>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-charcoal/60">Senin — Jumat</span>
                        <span class="text-charcoal">08.00 — 17.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-charcoal/60">Sabtu</span>
                        <span class="text-charcoal">09.00 — 15.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-charcoal/60">Minggu</span>
                        <span class="text-charcoal/40">Tutup</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
</script>
@endpush