<?php

namespace App\Helpers;

use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Auth;

class LogHelper
{
    public static function catat($aktivitas)
    {
        try {
            // 1. Ambil Kunci & URL dari .env
            // Pastikan path JSON sesuai dengan yang kamu simpan
            $factory = (new Factory)
                ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
                ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

            $database = $factory->createDatabase();

            // 2. Siapkan Data
            $data = [
                'user_id' => Auth::id() ?? 0,
                'nama_user' => Auth::user()->name ?? 'Tamu',
                'role' => Auth::user()->role ?? 'guest',
                'aktivitas' => $aktivitas,
                'waktu' => date('Y-m-d H:i:s'),
                'timestamp' => time() * 1000 // Buat sorting (biar yang baru di atas)
            ];

            // 3. Kirim ke Firebase (Folder 'logs')
            $database->getReference('logs')->push($data);

        } catch (\Exception $e) {
            // Kalau internet mati/error, jangan bikin web error. Catat di log laravel aja.
            \Log::error('Gagal kirim ke Firebase: ' . $e->getMessage());
        }
    }
}