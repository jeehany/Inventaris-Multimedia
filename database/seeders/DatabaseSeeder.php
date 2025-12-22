<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Penting untuk password

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin Default
        User::create([
            'name' => 'Admin Inventaris',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('password'), // Passwordnya 'password'
        ]);

        // 2. Panggil Seeder Kategori (Supaya kategori juga langsung terisi)
        // Pastikan class CategorySeeder sudah kamu buat sebelumnya, kalau belum hapus baris ini
        
    }
}