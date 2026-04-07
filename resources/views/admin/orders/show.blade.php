@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('breadcrumb', 'Detail Pesanan')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="font-display text-2xl text-charcoal">{{ $order->order_number }}</h2>
        <p class="text-xs text-charcoal/40 mt-0.5">{{ $order->created_at->format('d M Y, H:i') }}</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="text-xs text-charcoal/50 hover:text-walnut transition-colors">
        &larr; Kembali
    </a>
</div>

<div class="grid lg:grid-cols-3 gap-6">

    {{-- Left: Detail --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Produk --}}
        <div class="admin-card p-5">
            <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-4">Produk Dipesan</p>
            @if($order->product)
            <div class="flex gap-4">
                <div class="w-20 h-20 rounded-sm overflow-hidden bg-cream shrink-0">
                    @if($order->product->primaryImage)
                        <img src="{{ asset('storage/' . $order->product->primaryImage->path) }}"
                             alt="{{ $order->product->name }}" class="w-full h-full object-cover">
                    @endif
                </div>
                <div>
                    <p class="font-medium text-charcoal">{{ $order->product->name }}</p>
                    <p class="text-sm text-charcoal/50 mt-0.5">{{ $order->product->material }}</p>
                    <p class="text-sm text-walnut mt-1">{{ $order->product->formatted_price }}</p>
                    <p class="text-xs text-charcoal/50 mt-1">Qty: <strong>{{ $order->quantity }}</strong></p>
                </div>
            </div>
            @else
            <p class="text-sm text-charcoal/40 italic">Produk telah dihapus</p>
            @endif
        </div>

        {{-- Data Pelanggan --}}
        <div class="admin-card p-5">
            <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-4">Data Pelanggan</p>
            <div class="space-y-3 text-sm">
                @foreach([
                    ['Nama',    $order->customer_name],
                    ['Email',   $order->customer_email],
                    ['Telepon', $order->customer_phone],
                    ['Alamat',  $order->customer_address],
                ] as [$label, $value])
                <div class="flex gap-4">
                    <span class="text-charcoal/40 w-20 shrink-0">{{ $label }}</span>
                    <span class="text-charcoal">{{ $value }}</span>
                </div>
                @endforeach
                @if($order->notes)
                <div class="flex gap-4">
                    <span class="text-charcoal/40 w-20 shrink-0">Catatan</span>
                    <span class="text-charcoal">{{ $order->notes }}</span>
                </div>
                @endif
            </div>
        </div>

    </div>

    {{-- Right: Status & Actions --}}
    <div class="space-y-5">

        {{-- Status Saat Ini --}}
        <div class="admin-card p-5">
            <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-3">Status Pesanan</p>
            <span class="badge text-sm {{ $order->status_color }} px-4 py-1.5">
                {{ $order->status_label }}
            </span>
            @if($order->confirmed_at)
            <p class="text-xs text-charcoal/40 mt-3">Dikonfirmasi: {{ $order->confirmed_at->format('d M Y, H:i') }}</p>
            @endif
            @if($order->completed_at)
            <p class="text-xs text-charcoal/40 mt-1">Selesai: {{ $order->completed_at->format('d M Y, H:i') }}</p>
            @endif
        </div>

        {{-- Update Status --}}
        <div class="admin-card p-5">
            <p class="text-[0.65rem] tracking-widest uppercase text-sand mb-4">Update Status</p>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="space-y-3">
                @csrf @method('PATCH')
                <div>
                    <select name="status"
                            class="w-full px-3 py-2 text-sm border border-sand/30 rounded-sm bg-white focus:outline-none focus:border-walnut text-charcoal cursor-pointer">
                        @foreach([
                            'pending'    => 'Menunggu',
                            'confirmed'  => 'Dikonfirmasi',
                            'processing' => 'Diproses',
                            'completed'  => 'Selesai',
                            'cancelled'  => 'Dibatalkan',
                        ] as $val => $label)
                        <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <textarea name="admin_notes" rows="3" placeholder="Catatan admin (opsional)..."
                              class="w-full px-3 py-2 text-sm border border-sand/30 rounded-sm bg-white focus:outline-none focus:border-walnut text-charcoal placeholder-sand-dark">{{ $order->admin_notes }}</textarea>
                </div>
                <button type="submit"
                        class="w-full py-2.5 bg-walnut text-cream text-xs tracking-widest uppercase rounded-sm hover:bg-walnut-dark transition-colors">
                    Simpan Status
                </button>
            </form>
        </div>

        {{-- Hapus --}}
        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
              onsubmit="return confirm('Hapus pesanan ini secara permanen?')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="w-full py-2.5 border border-red-200 text-red-500 text-xs tracking-widest uppercase rounded-sm hover:bg-red-50 transition-colors">
                Hapus Pesanan
            </button>
        </form>

    </div>
</div>

@endsection
