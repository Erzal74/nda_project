<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function ndas()
    {
        return $this->hasMany(Nda::class); // NDA yang dibuat user ini
    }

    public function assignedNdas()
    {
        return $this->belongsToMany(Nda::class, 'nda_user'); // NDA di mana user ini adalah anggota
    }
}
