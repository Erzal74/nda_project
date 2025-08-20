<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NdaFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'nda_id',
        'file_path',
    ];

    public function nda()
    {
        return $this->belongsTo(Nda::class);
    }
}
