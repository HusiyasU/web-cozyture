<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        if ($products->isEmpty()) {
            $this->command->warn('Tidak ada produk, order seeder dilewati.');
            return;
        }

        $samples = [
            ['name' => 'Budi Santoso',    'email' => 'budi@email.com',   'phone' => '08121234567', 'status' => 'pending'],
            ['name' => 'Siti Rahayu',     'email' => 'siti@email.com',   'phone' => '08129876543', 'status' => 'confirmed'],
            ['name' => 'Ahmad Fauzi',     'email' => 'ahmad@email.com',  'phone' => '08134567890', 'status' => 'processing'],
            ['name' => 'Dewi Lestari',    'email' => 'dewi@email.com',   'phone' => '08156789012', 'status' => 'completed'],
            ['name' => 'Rizky Pratama',   'email' => 'rizky@email.com',  'phone' => '08167890123', 'status' => 'pending'],
        ];

        foreach ($samples as $data) {
            Order::create([
                'order_number'     => Order::generateOrderNumber(),
                'product_id'       => $products->random()->id,
                'customer_name'    => $data['name'],
                'customer_email'   => $data['email'],
                'customer_phone'   => $data['phone'],
                'customer_address' => 'Jl. Contoh No. ' . rand(1, 99) . ', Banjarmasin',
                'quantity'         => rand(1, 3),
                'notes'            => null,
                'status'           => $data['status'],
                'confirmed_at'     => in_array($data['status'], ['confirmed', 'processing', 'completed']) ? now() : null,
                'completed_at'     => $data['status'] === 'completed' ? now() : null,
            ]);
        }

        $this->command->info('5 sample pesanan berhasil dibuat.');
    }
}
