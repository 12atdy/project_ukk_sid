<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangan';

    protected $fillable = [
        'kode_transaksi',
        'jenis_transaksi',
        'keterangan',
        'sumber_penerima',
        'jumlah',
        'tanggal_transaksi',
        'penanggung_jawab',
        'bukti',
        'user_id',
    ];

    // Relasi: Transaksi ini diinput oleh siapa?
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}