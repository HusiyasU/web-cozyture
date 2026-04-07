@extends('layouts.admin')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['label'=>'Total Produk',    'value'=> $stats['products']  ?? 0, 'icon'=>'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10', 'color'=>'text-walnut bg-walnut/10'],
        ['label'=>'Kategori',        'value'=> $stats['categories']?? 0, 'icon'=>'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z', 'color'=>'text-amber-700 bg-amber-100'],
        ['label'=>'Pesanan Masuk',   'value'=> $stats['orders']    ?? 0, 'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'color'=>'text-blue-700 bg-blue-100'],
        ['label'=>'Menunggu Konfirmasi','value'=>$stats['pending'] ?? 0, 'icon'=>'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color'=>'text-orange-700 bg-orange-100'],
    ] as $stat)
    <div class="admin-card p-5">
        <div class="flex items-start justify-between mb-3">
            <p class="text-xs text-charcoal/40 uppercase tracking-wide">{{ $stat['label'] }}</p>
            <span class="inline-flex p-1.5 rounded-md {{ $stat['color'] }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $stat['icon'] }}"/>
                </svg>
            </span>
        </div>
        <p class="font-display text-3xl text-charcoal">{{ $stat['value'] }}</p>
    </div>
    @endforeach
</div>

{{-- Recent Orders --}}
<div class="admin-card overflow-hidden">
    <div class="px-5 py-4 border-b border-sand/20 flex items-center justify-between">
        <h2 class="font-display text-lg text-charcoal">Pesanan Terbaru</h2>
        <a href="{{ route('admin.orders.index') }}" class="text-xs text-walnut hover:underline">Lihat semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead>
                <tr>
                    <th class="text-left">Nama Pelanggan</th>
                    <th class="text-left">Produk</th>
                    <th class="text-left">Tanggal</th>
                    <th class="text-left">Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders ?? [] as $order)
                <tr>
                    <td class="font-medium text-charcoal">{{ $order->customer_name }}</td>
                    <td>{{ $order->product->name ?? '-' }}</td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td>
                        <span class="badge
                            {{ $order->status === 'pending'    ? 'bg-orange-100 text-orange-700' : '' }}
                            {{ $order->status === 'confirmed'  ? 'bg-blue-100 text-blue-700'    : '' }}
                            {{ $order->status === 'completed'  ? 'bg-green-100 text-green-700'  : '' }}
                            {{ $order->status === 'cancelled'  ? 'bg-red-100 text-red-700'      : '' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}"
                           class="text-xs text-walnut hover:underline">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-charcoal/30 text-sm italic">
                        Belum ada pesanan masuk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection