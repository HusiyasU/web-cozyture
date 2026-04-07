<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'path',
        'alt',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
    ];

    // ===== AUTO DELETE FILE =====
    protected static function booted(): void
    {
        static::deleting(function ($image) {
            Storage::disk('public')->delete($image->path);
        });
    }

    // ===== RELATIONSHIPS =====
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ===== ACCESSORS =====
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }

    // ===== HELPERS =====

    /**
     * Jadikan gambar ini sebagai primary,
     * otomatis unset gambar primary lainnya di produk yang sama.
     */
    public function makePrimary(): void
    {
        ProductImage::where('product_id', $this->product_id)
            ->where('id', '!=', $this->id)
            ->update(['is_primary' => false]);

        $this->update(['is_primary' => true]);
    }
}
