<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $adjectives = ['Minimalis', 'Modern', 'Klasik', 'Skandinavia', 'Industrial', 'Rustik', 'Elegan'];
        $materials  = ['Kayu Jati', 'Kayu Mahoni', 'Rotan', 'MDF', 'Besi Tempa', 'Kayu Pinus', 'Bambu'];
        $colors     = ['Natural', 'Walnut', 'Oak', 'Putih', 'Hitam', 'Abu-abu', 'Cokelat Tua'];

        $adjective = $this->faker->randomElement($adjectives);
        $material  = $this->faker->randomElement($materials);
        $items     = ['Sofa', 'Meja Makan', 'Lemari', 'Kursi', 'Rak Buku', 'Ranjang', 'Coffee Table', 'Nakas'];
        $item      = $this->faker->randomElement($items);
        $name      = "{$adjective} {$item} {$material}";

        $price = $this->faker->randomElement([
            499000, 750000, 1200000, 1800000, 2500000,
            3200000, 4500000, 6000000, 8500000, 12000000,
        ]);

        return [
            'category_id'       => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'name'              => $name,
            'slug'              => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 999),
            'short_description' => $this->faker->sentence(10),
            'description'       => implode("\n\n", $this->faker->paragraphs(3)),
            'price'             => $price,
            'material'          => $material,
            'dimension'         => $this->faker->numberBetween(60, 200) . ' x ' .
                                   $this->faker->numberBetween(40, 100) . ' x ' .
                                   $this->faker->numberBetween(40, 120) . ' cm',
            'color'             => $this->faker->randomElement($colors),
            'stock'             => $this->faker->numberBetween(0, 20),
            'is_active'         => $this->faker->boolean(85), // 85% aktif
            'is_featured'       => $this->faker->boolean(20), // 20% featured
            'sort_order'        => $this->faker->numberBetween(0, 50),
        ];
    }

    // State: pastikan produk aktif
    public function active(): static
    {
        return $this->state(['is_active' => true]);
    }

    // State: produk featured
    public function featured(): static
    {
        return $this->state(['is_active' => true, 'is_featured' => true]);
    }
}
