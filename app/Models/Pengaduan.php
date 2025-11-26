<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;
    
    protected $table = 'pengaduan';
    protected $guarded = ['id'];

    // Relasi: Pengaduan dibuat oleh siapa? (User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi: Pengaduan punya tanggapan apa tidak?
    public function tanggapan()
    {
        return $this->hasOne(TanggapanPengaduan::class, 'pengaduan_id');
    }
}