<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'no';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no',
        'name',
        'email',
        'nip',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopePegawai($query)
    {
        return $query->where('role', 'pegawai');
    }

    public function ndas()
    {
        return $this->hasMany(Nda::class, 'user_id', 'no');
    }

    public function assignedNdas()
    {
        return $this->belongsToMany(Nda::class, 'nda_user', 'user_id', 'no');
    }
}
