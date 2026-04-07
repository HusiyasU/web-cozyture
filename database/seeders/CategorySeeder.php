<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Sofa & Kursi',       'description' => 'Koleksi sofa dan kursi untuk ruang tamu yang nyaman dan elegan.'],
            ['name' => 'Meja Makan',          'description' => 'Meja makan dari berbagai ukuran dan bahan pilihan.'],
            ['name' => 'Lemari & Kabinet',    'description' => 'Lemari pakaian dan kabinet penyimpanan untuk kamar tidur.'],
            ['name' => 'Ranjang & Kasur',     'description' => 'Ranjang dan kasur berkualitas untuk tidur yang nyaman.'],
            ['name' => 'Meja Kerja',          'description' => 'Meja kerja ergonomis untuk produktivitas di rumah atau kantor.'],
            ['name' => 'Rak & Shelving',      'description' => 'Rak buku dan shelving multifungsi untuk setiap ruangan.'],
            ['name' => 'Coffee Table',        'description' => 'Meja tamu dan coffee table sebagai pusat ruang keluarga.'],
            ['name' => 'Nakas & Meja Rias',   'description' => 'Nakas dan meja rias untuk melengkapi kamar tidur.'],
        ];

        foreach ($categories as $index => $data) {
            Category::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'name'        => $data['name'],
                    'slug'        => Str::slug($data['name']),
                    'description' => $data['description'],
                    'is_active'   => true,
                    'sort_order'  => $index + 1,
                ]
            );
        }

        $this->command->info('8 kategori berhasil dibuat.');
    }
}
