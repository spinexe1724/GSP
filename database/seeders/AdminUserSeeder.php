<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gratama.com'],
            [
                'name'      => 'Administrator',
                'password'  => Hash::make('password123'),
                'is_admin'  => true,
                'clprnoktp' => '0', // Tambahkan baris ini
                'no_telepon' => '0', // Tambahkan baris ini
            ]
        );
    }
}