<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::create([
    'name'     => 'Administrator',
    'email'    => 'admin@gratama.com',
    'password' => bcrypt('password123'),
    'role'     => 'admin',     // <-- Pastikan role-nya 'admin', bukan 'showroom'
    'is_admin' => 1,           // <-- Menandakan ini admin pusat
    'showroom_id' => null,     // <-- Admin pusat tidak punya showroom
]);
    }
}