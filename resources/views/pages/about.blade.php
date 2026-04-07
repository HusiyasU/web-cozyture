@extends('layouts.app')

@section('title', 'Tentang Kami')
@section('meta_description', 'Kenali lebih dekat Cozyture — toko furnitur premium yang menghadirkan kenyamanan ke rumah Anda.')

@push('styles')
<style>
    .reveal { opacity: 0; transform: translateY(24px); transition: opacity 0.7s ease, transform 0.7s ease; }
    .reveal.visible { opacity: 1; transform: none; }
</style>
@endpush

@section('content')

{{-- Hero --}}
<div class="bg-charcoal text-cream py-20">
    <div class="max-w-4xl mx-auto px-6 lg:px-12 text-center">
        <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-3 reveal">Tentang Kami</p>
        <h1 class="font-display text-5xl lg:text-6xl leading-tight mb-6 reveal" style="transition-delay:.1s">
            Kami percaya rumah adalah <em class="text-sand font-normal">cerita hidupmu</em>
        </h1>
        <p class="text-cream/50 text-base leading-relaxed max-w-xl mx-auto reveal" style="transition-delay:.2s">
            Cozyture hadir untuk membantu kamu menemukan furnitur yang bukan sekadar indah,
            tapi juga bermakna dan bertahan lama.
        </p>
    </div>
</div>

{{-- Story --}}
<section class="max-w-5xl mx-auto px-6 lg:px-12 py-20">
    <div class="grid lg:grid-cols-2 gap-14 items-center">
        <div class="reveal">
            <div class="aspect-[4/5] bg-cream rounded-sm overflow-hidden flex items-center justify-center text-sand/20 font-display text-5xl italic">
                foto toko
            </div>
        </div>
        <div class="reveal" style="transition-delay:.15s">
            <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-3">Kisah Kami</p>
            <h2 class="font-display text-4xl text-charcoal mb-5">Dari passion menjadi kepercayaan</h2>
            <div class="space-y-4 text-sm text-charcoal/60 leading-relaxed">
                <p>
                    Cozyture lahir dari keyakinan sederhana: setiap rumah berhak mendapatkan furnitur
                    yang indah, berkualitas, dan terjangkau. Berawal dari sebuah toko kecil di Banjarmasin,
                    kami terus bertumbuh bersama kepercayaan pelanggan setia kami.
                </p>
                <p>
                    Kami bekerja sama langsung dengan supplier dan pengrajin furnitur terpilih,
                    memastikan setiap produk yang sampai ke tanganmu telah melewati seleksi ketat —
                    dari kualitas bahan, ketahanan, hingga estetika.
                </p>
                <p>
                    Lebih dari sekadar menjual furnitur, kami ingin menjadi bagian dari perjalananmu
                    dalam menciptakan ruang yang benar-benar terasa seperti rumah.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Values --}}
<section class="bg-cream py-20">
    <div class="max-w-5xl mx-auto px-6 lg:px-12">
        <div class="text-center mb-14 reveal">
            <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-2">Nilai Kami</p>
            <h2 class="font-display text-4xl text-charcoal">Yang kami pegang teguh</h2>
        </div>
        <div class="grid sm:grid-cols-3 gap-8">
            @foreach([
                [
                    'title' => 'Kualitas Tanpa Kompromi',
                    'desc'  => 'Setiap produk dipilih langsung dari supplier terpercaya dan melalui quality check sebelum sampai ke kamu.',
                    'icon'  => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z',
                ],
                [
                    'title' => 'Pelayanan Personal',
                    'desc'  => 'Kami bukan platform besar yang anonim. Setiap pesanan ditangani langsung oleh tim kami dengan perhatian penuh.',
                    'icon'  => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
                ],
                [
                    'title' => 'Kejujuran & Transparansi',
                    'desc'  => 'Harga yang tertera adalah harga sebenarnya. Tidak ada biaya tersembunyi, tidak ada janji yang tidak kami tepati.',
                    'icon'  => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                ],
            ] as $i => $val)
            <div class="text-center reveal" style="transition-delay: {{ $i * 0.12 }}s">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-walnut/10 mb-5">
                    <svg class="w-5 h-5 text-walnut" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $val['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="font-display text-xl text-charcoal mb-2">{{ $val['title'] }}</h3>
                <p class="text-sm text-charcoal/55 leading-relaxed">{{ $val['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="bg-walnut text-cream py-16">
    <div class="max-w-4xl mx-auto px-6 lg:px-12">
        <div class="grid grid-cols-3 gap-8 text-center">
            @foreach([
                ['200+', 'Pilihan Produk'],
                ['500+', 'Pelanggan Puas'],
                ['50+',  'Supplier Terpilih'],
            ] as $stat)
            <div class="reveal">
                <p class="font-display text-5xl text-sand mb-2">{{ $stat[0] }}</p>
                <p class="text-[0.65rem] tracking-widest uppercase text-cream/50">{{ $stat[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="max-w-3xl mx-auto px-6 lg:px-12 py-20 text-center reveal">
    <h2 class="font-display text-4xl text-charcoal mb-4">Siap memulai?</h2>
    <p class="text-sm text-charcoal/50 mb-8">Jelajahi katalog kami atau hubungi tim Cozyture langsung.</p>
    <div class="flex flex-wrap justify-center gap-4">
        <a href="{{ route('catalog.index') }}"
           class="px-7 py-3.5 bg-walnut text-cream text-xs tracking-widest uppercase hover:bg-walnut-dark transition-colors rounded-sm">
            Lihat Katalog
        </a>
        <a href="{{ route('contact') }}"
           class="px-7 py-3.5 border border-sand/40 text-charcoal text-xs tracking-widest uppercase hover:border-walnut hover:text-walnut transition-colors rounded-sm">
            Hubungi Kami
        </a>
    </div>
</section>

@endsection

@push('scripts')
<script>
    const obs = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
</script>
@endpush