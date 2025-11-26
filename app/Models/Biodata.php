<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;
    
    protected $table = 'biodata';
    protected $guarded = ['id'];

    // [BARU] Relasi balik ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}