<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'product_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'quantity',
        'notes',
        'status',
        'admin_notes',
        'confirmed_at',
        'completed_at',
    ];

    protected $casts = [
        'quantity'     => 'integer',
        'confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // ===== AUTO ORDER NUMBER =====
    protected static function booted(): void
    {
        static::creating(function ($order) {
            $order->order_number ??= self::generateOrderNumber();
        });
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'CTR-' . now()->format('Ymd');
        $last   = self::where('order_number', 'like', $prefix . '-%')
                      ->orderByDesc('id')
                      ->value('order_number');

        $sequence = $last
            ? (int) substr($last, -4) + 1
            : 1;

        return $prefix . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    // ===== RELATIONSHIPS =====
    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    // ===== SCOPES =====
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeLatest($query)
    {
        return $query->orderByDesc('created_at');
    }

    // ===== ACCESSORS =====
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'    => 'Menunggu',
            'confirmed'  => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'completed'  => 'Selesai',
            'cancelled'  => 'Dibatalkan',
            default      => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'    => 'bg-orange-100 text-orange-700',
            'confirmed'  => 'bg-blue-100 text-blue-700',
            'processing' => 'bg-purple-100 text-purple-700',
            'completed'  => 'bg-green-100 text-green-700',
            'cancelled'  => 'bg-red-100 text-red-700',
            default      => 'bg-gray-100 text-gray-700',
        };
    }

    // ===== HELPERS =====
    public function confirm(): void
    {
        $this->update([
            'status'       => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }

    public function complete(): void
    {
        $this->update([
            'status'       => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function cancel(): void
    {
        $this->update(['status' => 'cancelled']);
    }
}
