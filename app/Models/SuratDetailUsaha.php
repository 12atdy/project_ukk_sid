<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan ini biar lengkap
use Illuminate\Database\Eloquent\Model;

class SuratDetailUsaha extends Model
{
    use HasFactory;

    // BERI TAHU NAMA TABEL YANG BENAR (TANPA 'S')
    protected $table = 'surat_detail_usaha'; 
    
    protected $guarded = ['id'];
    public $timestamps = false; // Tambahkan jika tabelmu tidak punya created_at/updated_at
}