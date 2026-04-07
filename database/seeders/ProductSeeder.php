<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category' => 'Sofa & Kursi',
                'name'     => 'Sofa Minimalis 3 Dudukan',
                'short_description' => 'Sofa modern dengan rangka kayu solid dan busa berkualitas tinggi.',
                'price'    => 4500000,
                'material' => 'Kayu Jati & Busa High-Density',
                'dimension'=> '210 x 85 x 80 cm',
                'color'    => 'Abu-abu',
                'stock'    => 5,
                'is_featured' => true,
            ],
            [
                'category' => 'Sofa & Kursi',
                'name'     => 'Kursi Skandinavia Kayu Pinus',
                'short_description' => 'Kursi bergaya Skandinavia dengan kaki kayu pinus natural.',
                'price'    => 1200000,
                'material' => 'Kayu Pinus & Kain Linen',
                'dimension'=> '55 x 55 x 80 cm',
                'color'    => 'Natural',
                'stock'    => 12,
                'is_featured' => true,
            ],
            [
                'category' => 'Meja Makan',
                'name'     => 'Meja Makan Kayu Jati 6 Kursi',
                'short_description' => 'Meja makan solid kayu jati dengan finishing natural yang tahan lama.',
                'price'    => 8500000,
                'material' => 'Kayu Jati Solid',
                'dimension'=> '180 x 90 x 75 cm',
                'color'    => 'Walnut',
                'stock'    => 3,
                'is_featured' => true,
            ],
            [
                'category' => 'Meja Makan',
                'name'     => 'Meja Makan Minimalis 4 Kursi',
                'short_description' => 'Meja makan modern dengan desain clean untuk dapur kecil.',
                'price'    => 3200000,
                'material' => 'MDF & Kayu Karet',
                'dimension'=> '120 x 70 x 75 cm',
                'color'    => 'Putih',
                'stock'    => 7,
                'is_featured' => false,
            ],
            [
                'category' => 'Lemari & Kabinet',
                'name'     => 'Lemari Pakaian 4 Pintu Sliding',
                'short_description' => 'Lemari dengan pintu geser cermin yang hemat ruang.',
                'price'    => 6000000,
                'material' => 'MDF & Kaca',
                'dimension'=> '200 x 60 x 220 cm',
                'color'    => 'Cokelat Tua',
                'stock'    => 4,
                'is_featured' => false,
            ],
            [
                'category' => 'Coffee Table',
                'name'     => 'Coffee Table Rotan Natural',
                'short_description' => 'Meja tamu rotan dengan sentuhan bohemian yang hangat.',
                'price'    => 1800000,
                'material' => 'Rotan & Kayu Mahoni',
                'dimension'=> '100 x 60 x 45 cm',
                'color'    => 'Natural',
                'stock'    => 8,
                'is_featured' => true,
            ],
            [
                'category' => 'Meja Kerja',
                'name'     => 'Meja Kerja Industrial Besi Kayu',
                'short_description' => 'Meja kerja industrial dengan kombinasi besi dan kayu solid.',
                'price'    => 2500000,
                'material' => 'Kayu Pinus & Besi Tempa',
                'dimension'=> '140 x 60 x 75 cm',
                'color'    => 'Oak',
                'stock'    => 6,
                'is_featured' => false,
            ],
            [
                'category' => 'Rak & Shelving',
                'name'     => 'Rak Buku Dinding 5 Tingkat',
                'short_description' => 'Rak buku minimalis yang dipasang di dinding, hemat ruang.',
                'price'    => 950000,
                'material' => 'MDF',
                'dimension'=> '80 x 25 x 150 cm',
                'color'    => 'Putih',
                'stock'    => 15,
                'is_featured' => false,
            ],
        ];

        foreach ($products as $index => $data) {
            $category = Category::where('name', $data['category'])->first();
            if (! $category) continue;

            $product = Product::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'category_id'       => $category->id,
                    'name'              => $data['name'],
                    'slug'              => Str::slug($data['name']),
                    'short_description' => $data['short_description'],
                    'description'       => $data['short_description'] . ' Dibuat dengan bahan pilihan dan dikerjakan oleh pengrajin berpengalaman. Cocok untuk hunian modern maupun klasik.',
                    'price'             => $data['price'],
                    'material'          => $data['material'],
                    'dimension'         => $data['dimension'],
                    'color'             => $data['color'],
                    'stock'             => $data['stock'],
                    'is_active'         => true,
                    'is_featured'       => $data['is_featured'],
                    'sort_order'        => $index + 1,
                ]
            );
        }

        $this->command->info('8 produk berhasil dibuat.');
    }
}
