<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai konvensi (beritas -> berita)
    protected $table = 'berita';

    // Definisikan kolom yang boleh diisi secara massal
    protected $fillable = [
        'judul',
        'isi',
        'gambar',
        'user_id',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model User.
     * Satu berita hanya ditulis oleh satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}