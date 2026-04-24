<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@techshop.com'],
            [
                'name' => 'Admin TechShop',
                'password' => Hash::make('password123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@techshop.com'],
            [
                'name' => 'Staff Penjualan',
                'password' => Hash::make('password123'),
            ]
        );
    }
}