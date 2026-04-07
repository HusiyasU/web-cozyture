<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    // ===== HELPERS =====

    /**
     * Ambil nilai setting by key.
     * Contoh: Setting::get('store_name', 'Cozyture')
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever("setting_{$key}", function () use ($key, $default) {
            return self::where('key', $key)->value('value') ?? $default;
        });
    }

    /**
     * Simpan atau update setting.
     * Contoh: Setting::set('store_phone', '08123456789')
     */
    public static function set(string $key, mixed $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting_{$key}");
    }

    /**
     * Ambil banyak setting sekaligus sebagai array.
     * Contoh: Setting::getMany(['store_name', 'store_email'])
     */
    public static function getMany(array $keys): array
    {
        return self::whereIn('key', $keys)
            ->pluck('value', 'key')
            ->toArray();
    }
}
