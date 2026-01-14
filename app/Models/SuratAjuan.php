<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratAjuan extends Model
{
    use HasFactory;
    
    protected $table = 'surat_ajuan';
    protected $guarded = ['id'];

    protected $casts = [
        'lampiran' => 'array',
    ];

    // Relasi ke Pemohon (User Warga)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // --- RELASI KE DETAIL SURAT ---
    // Ini biar Admin bisa panggil datanya otomatis
    
    public function detailUsaha()
    {
        return $this->hasOne(SuratDetailUsaha::class, 'ajuan_id');
    }

    public function detailNikah()
    {
        return $this->hasOne(SuratDetailNikah::class, 'ajuan_id');
    }

    public function detailTanah()
    {
        return $this->hasOne(SuratDetailTanah::class, 'ajuan_id');
    }

    public function detailKelahiran()
    {
        return $this->hasOne(SuratDetailKelahiran::class, 'ajuan_id');
    }

    public function detailKematian()
    {
        return $this->hasOne(SuratDetailKematian::class, 'ajuan_id');
    }

    public function detailDomisili()
    {
        return $this->hasOne(SuratDetailDomisili::class, 'ajuan_id');
    }
}