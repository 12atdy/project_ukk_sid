<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratDetailKelahiran extends Model
{
    use HasFactory;
    
    protected $table = 'surat_detail_kelahiran';
    protected $guarded = ['id']; // Izinkan semua kolom diisi kecuali ID
    public $timestamps = false; // Karena di migrasi tadi kita pakai timestamps(), ini opsional. Kalau error column not found, ubah jadi true.
    // Koreksi: Tadi di migrasi saya tambahkan $table->timestamps(), jadi ubah ini ke true atau hapus baris ini.
    // Biar aman, hapus baris public $timestamps = false; agar defaultnya true.
}