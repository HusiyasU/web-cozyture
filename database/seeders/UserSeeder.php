<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@cozyture.id'],
            [
                'name'     => 'Admin Cozyture',
                'email'    => 'admin@cozyture.id',
                'password' => Hash::make('cozyture123'),
            ]
        );

        $this->command->info('Admin user created: admin@cozyture.id / cozyture123');
    }
}
