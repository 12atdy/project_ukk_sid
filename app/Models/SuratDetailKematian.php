<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratDetailKematian extends Model
{
    use HasFactory;
    
    protected $table = 'surat_detail_kematian';
    protected $guarded = ['id'];
}