<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanggapanPengaduan extends Model
{
    use HasFactory;
    
    protected $table = 'tanggapan_pengaduan';
    protected $guarded = ['id'];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    // Relasi ke Admin (User)
    public function admin()
    {
        // Hubungkan ke kolom 'user_id' di tabel tanggapan
        return $this->belongsTo(User::class, 'user_id'); 
    }
}