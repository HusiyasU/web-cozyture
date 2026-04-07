<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'material',
        'dimension',
        'color',
        'stock',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'stock'      => 'integer',
        'is_active'  => 'boolean',
        'is_featured'=> 'boolean',
        'sort_order' => 'integer',
    ];

    // ===== AUTO SLUG =====
    protected static function booted(): void
    {
        static::creating(function ($product) {
            $product->slug ??= Str::slug($product->name);
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && ! $product->isDirty('slug')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // ===== RELATIONSHIPS =====
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // ===== SCOPES =====
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    // ===== ACCESSORS =====
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getPrimaryImageUrlAttribute(): ?string
    {
        $primary = $this->primaryImage;

        // Fallback ke gambar pertama jika tidak ada yang is_primary
        if (! $primary) {
            $primary = $this->images->first();
        }

        return $primary ? asset('storage/' . $primary->path) : null;
    }

    public function getIsInStockAttribute(): bool
    {
        return $this->stock > 0;
    }
}
