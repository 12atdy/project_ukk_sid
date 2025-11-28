<?php

namespace Database\Seeders;

// ⚠️ JANGAN LUPA DUA BARIS INI BIAR GAK MERAH
use App\Models\User;
use App\Models\Biodata; 
// -------------------------------------------

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        User::create([
            'name' => 'Administrator Desa',
            'email' => 'admin@desasidokerto.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Buat Akun WARGA (Budi)
        $warga = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@warga.com',
            'password' => Hash::make('password123'),
            'role' => 'warga',
        ]);

        // 3. BUAT BIODATA UNTUK BUDI
        Biodata::create([
            'user_id'       => $warga->id,
            'nik'           => '3515123456780001',
            'no_kk'         => '3515098765430002',
            'nama_lengkap'  => 'Budi Santoso', 
            'tempat_lahir'  => 'Sidoarjo',
            'tanggal_lahir' => '1990-05-15',
            'jenis_kelamin' => 'Laki-laki',
            'alamat'        => 'Dusun Krajan RT 01 RW 01, Desa Sidokerto',
            'agama'         => 'Islam',
            'status_perkawinan' => 'Kawin', // Ganti 'status_kawin' jadi 'status_perkawinan'
            'pekerjaan'     => 'Wiraswasta',
        ]);
    }
}