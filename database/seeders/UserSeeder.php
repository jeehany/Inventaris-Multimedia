<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin (Petugas Inventaris)
        User::create([
            'name' => 'Admin Inventaris',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('123456'), // Passwordnya 123456
            'role' => 'admin',
        ]);

        // 2. Buat Akun Kepala Program (Yang Approve)
        User::create([
            'name' => 'Bapak Kepala Program',
            'email' => 'kepala@sekolah.com',
            'password' => Hash::make('123456'), // Passwordnya 123456
            'role' => 'head',
        ]);
    }
}