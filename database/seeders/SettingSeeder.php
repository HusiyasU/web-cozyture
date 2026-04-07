<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Info toko
            'store_name'        => 'Cozyture',
            'store_tagline'     => 'Furniture & Living',
            'store_description' => 'Kami menghadirkan furnitur berkualitas tinggi dari supplier terpercaya langsung ke rumah Anda.',

            // Kontak
            'store_phone'       => '+62 812-3456-7890',
            'store_email'       => 'hello@cozyture.id',
            'store_address'     => 'Jl. Kayu Manis No. 12, Banjarmasin, Kalimantan Selatan',
            'store_maps_url'    => '',

            // Sosial media
            'social_instagram'  => '',
            'social_whatsapp'   => '6281234567890',
            'social_facebook'   => '',

            // SEO
            'meta_title'        => 'Cozyture — Toko Furnitur Premium',
            'meta_description'  => 'Hadirkan furnitur impian ke ruang hidupmu dengan kualitas premium dari Cozyture.',

            // Pengaturan toko
            'products_per_page' => '12',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        $this->command->info('Settings berhasil diisi.');
    }
}
