@extends('layouts.admin')

@section('title', 'Pesanan')
@section('breadcrumb', 'Pesanan')

@section('content')

<div class="flex items-center justify-between mb-6">
    <h2 class="font-display text-2xl text-charcoal">Daftar Pesanan</h2>
</div>

{{-- Status Tabs --}}
<div class="flex gap-2 flex-wrap mb-5">
    @foreach([
        ''           => ['label' => 'Semua',      'count' => $statusCounts['all']],
        'pending'    => ['label' => 'Menunggu',    'count' => $statusCounts['pending']],
        'confirmed'  => ['label' => 'Dikonfirmasi','count' => $statusCounts['confirmed']],
        'processing' => ['label' => 'Diproses',    'count' => $statusCounts['processing']],
        'completed'  => ['label' => 'Selesai',     'count' => $statusCounts['completed']],
        'cancelled'  => ['label' => 'Dibatalkan',  'count' => $statusCounts['cancelled']],
    ] as $val => $data)
    <a href="{{ route('admin.orders.index', array_merge(request()->except(['status','page']), $val ? ['status' => $val] : [])) }}"
       class="px-3 py-1.5 rounded-full text-xs transition-colors
              {{ request('status', '') === $val
                  ? 'bg-walnut text-cream'
                  : 'bg-cream text-charcoal/60 hover:text-charcoal border border-sand/30' }}">
        {{ $data['label'] }}
        <span class="ml-1 opacity-70">({{ $data['count'] }})</span>
    </a>
    @endforeach
</div>

{{-- Search --}}
<div class="admin-card p-4 mb-5">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex gap-3">
        @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama, email, no. order..."
               class="flex-1 px-3 py-2 text-sm border border-sand/30 rounded-sm bg-white focus:outline-none focus:border-walnut text-charcoal">
        <button type="submit" class="px-4 py-2 bg-walnut/10 text-walnut text-sm rounded-sm hover:bg-walnut/20 transition-colors">Cari</button>
        @if(request('search'))
        <a href="{{ route('admin.orders.index', request()->except('search')) }}" class="px-4 py-2 text-sm text-charcoal/50 hover:text-charcoal">Reset</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="admin-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table w-full">
            <thead>
                <tr>
                    <th class="text-left">No. Order</th>
                    <th class="text-left">Pelanggan</th>
                    <th class="text-left">Produk</th>
                    <th class="text-left">Qty</th>
                    <th class="text-left">Status</th>
                    <th class="text-left">Tanggal</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="font-mono text-xs text-charcoal/60">{{ $order->order_number }}</td>
                    <td>
                        <p class="font-medium text-charcoal text-sm">{{ $order->customer_name }}</p>
                        <p class="text-xs text-charcoal/40">{{ $order->customer_phone }}</p>
                    </td>
                    <td class="text-sm max-w-[180px] truncate">{{ $order->product->name ?? '(produk dihapus)' }}</td>
                    <td class="text-sm">{{ $order->quantity }}</td>
                    <td>
                        <span class="badge {{ $order->status_color }}">{{ $order->status_label }}</span>
                    </td>
                    <td class="text-xs text-charcoal/50">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="text-xs text-walnut hover:underline">Detail</a>
                            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                                  onsubmit="return confirm('Hapus pesanan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs text-red-500 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-charcoal/30 italic text-sm">Tidak ada pesanan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="px-5 py-3 border-t border-sand/20 flex justify-end">
        {{ $orders->links('vendor.pagination.cozyture') }}
    </div>
    @endif
</div>

@endsection
