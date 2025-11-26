<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun ADMIN (Pintu Belakang)
        // Orang lain tidak bisa daftar jadi admin, cuma bisa lewat sini
        User::create([
            'name' => 'Administrator Desa',
            'email' => 'admin@desasidokerto.com',
            'password' => Hash::make('password123'), // Password rahasia admin
            'role' => 'admin',
        ]);

        // 2. Buat akun contoh Warga (Untuk testing)
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@warga.com',
            'password' => Hash::make('password123'),
            'role' => 'warga',
        ]);
    }
}