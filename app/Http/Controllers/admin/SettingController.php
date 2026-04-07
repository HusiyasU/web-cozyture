<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // Semua key yang diizinkan diubah lewat form
    private array $allowedKeys = [
        'store_name',
        'store_tagline',
        'store_description',
        'store_phone',
        'store_email',
        'store_address',
        'store_maps_url',
        'social_instagram',
        'social_whatsapp',
        'social_facebook',
        'meta_title',
        'meta_description',
        'products_per_page',
    ];

    public function index()
    {
        $settings = Setting::whereIn('key', $this->allowedKeys)
            ->pluck('value', 'key')
            ->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'store_name'        => 'required|string|max:100',
            'store_email'       => 'nullable|email|max:100',
            'store_phone'       => 'nullable|string|max:20',
            'store_address'     => 'nullable|string|max:500',
            'products_per_page' => 'nullable|integer|min:4|max:48',
        ], [
            'store_name.required' => 'Nama toko wajib diisi.',
            'store_email.email'   => 'Format email tidak valid.',
        ]);

        foreach ($this->allowedKeys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
