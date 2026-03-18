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
        // 1. Membuat Akun Staff
        User::create([
            'name' => 'Staff Multimedia',
            'email' => 'staff@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'staff',
            'email_verified_at' => now(),
        ]);

        // 2. Membuat Akun Kepala
        User::create([
            'name' => 'Kepala Multimedia',
            'email' => 'kepala@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'kepala',
            'email_verified_at' => now(),
        ]);

        // 3. Membuat Akun Bendahara
        User::create([
            'name' => 'Bendahara Keuangan',
            'email' => 'bendahara@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'bendahara',
            'email_verified_at' => now(),
        ]);
    }
}