<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratDetailDomisili extends Model
{
    use HasFactory;
    
    protected $table = 'surat_detail_domisili';
    protected $guarded = ['id'];
}