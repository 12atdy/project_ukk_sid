<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;

    // Pastikan nama tabelnya benar (biasanya Laravel nyari 'biodatas')
    protected $table = 'biodata'; 

    // IZINKAN SEMUA KOLOM DIISI (Biar gak error Mass Assignment)
    protected $guarded = ['id']; 

    // Relasi balik ke User (Opsional tapi bagus ada)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}