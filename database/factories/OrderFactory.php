<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        $status    = $this->faker->randomElement(['pending', 'confirmed', 'processing', 'completed', 'cancelled']);
        $createdAt = $this->faker->dateTimeBetween('-3 months', 'now');

        return [
            'order_number'     => Order::generateOrderNumber(),
            'product_id'       => Product::inRandomOrder()->first()?->id,
            'customer_name'    => $this->faker->name(),
            'customer_email'   => $this->faker->safeEmail(),
            'customer_phone'   => '08' . $this->faker->numerify('#########'),
            'customer_address' => $this->faker->address(),
            'quantity'         => $this->faker->numberBetween(1, 5),
            'notes'            => $this->faker->boolean(40) ? $this->faker->sentence() : null,
            'status'           => $status,
            'admin_notes'      => $this->faker->boolean(30) ? $this->faker->sentence() : null,
            'confirmed_at'     => in_array($status, ['confirmed', 'processing', 'completed']) ? $createdAt : null,
            'completed_at'     => $status === 'completed' ? $this->faker->dateTimeBetween($createdAt, 'now') : null,
            'created_at'       => $createdAt,
            'updated_at'       => $createdAt,
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => 'pending', 'confirmed_at' => null, 'completed_at' => null]);
    }
}
