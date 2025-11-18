<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratAjuan extends Model
{
    use HasFactory;

    protected $table = 'surat_ajuan'; // Nama tabel di database

    protected $fillable = [
        'user_id',
        'jenis_surat',
        'nomor_surat',
        'tanggal_ajuan',
        'status',
        'keterangan_admin',
    ];

    // Relasi: Satu surat dimiliki oleh satu user (warga)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}