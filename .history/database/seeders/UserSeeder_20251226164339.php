<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Jangan lupa import Model User
use Illuminate\Support\Facades\Hash; // Jangan lupa import Hash

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Membuat Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'), // Password default: password
            'role' => 'admin', // Sesuai enum ['admin', 'head']
            'email_verified_at' => now(),
        ]);

        // 2. Membuat Akun Kepala (Head)
        User::create([
            'name' => 'Kepala',
            'email' => 'kepala@gmail.com',
            'password' => Hash::make('12345678'), // Password default: password
            'role' => 'head', // Sesuai enum ['admin', 'head']
            'email_verified_at' => now(),
        ]);
    }
}