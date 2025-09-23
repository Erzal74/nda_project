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
        'member_index',
        'signature_date',
    ];

    protected $casts = [
        'signature_date' => 'date',
    ];

    public function nda()
    {
        return $this->belongsTo(Nda::class);
    }
}
