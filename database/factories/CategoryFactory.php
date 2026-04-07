<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement([
            'Sofa & Kursi', 'Meja Makan', 'Lemari & Kabinet',
            'Ranjang & Kasur', 'Meja Kerja', 'Rak & Shelving',
            'Coffee Table', 'Nakas', 'Kursi Tamu', 'Meja Rias',
        ]);

        return [
            'name'        => $name,
            'slug'        => Str::slug($name),
            'description' => $this->faker->sentence(12),
            'image'       => null,
            'is_active'   => true,
            'sort_order'  => $this->faker->numberBetween(0, 10),
        ];
    }
}
