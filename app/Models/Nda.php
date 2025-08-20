<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Nda extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'start_date',
        'end_date',
        'project_duration',
        'nda_signature_date',
        'description',
        'token',
        'user_id',
        'members',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'nda_signature_date' => 'date',
        'members' => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function files()
    {
        return $this->hasMany(NdaFile::class);
    }

    public function getFormattedDurationAttribute()
    {
        if ($this->project_duration) {
            return $this->project_duration . ' hari';
        }
        return '-';
    }

    public function calculateProjectDuration()
    {
        if ($this->start_date && $this->end_date) {
            $startDate = Carbon::parse($this->start_date);
            $endDate = Carbon::parse($this->end_date);
            return $endDate->diffInDays($startDate);
        }
        return null;
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($nda) {
            if ($nda->start_date && $nda->end_date) {
                $nda->project_duration = $nda->calculateProjectDuration();
            }
        });
    }
}
