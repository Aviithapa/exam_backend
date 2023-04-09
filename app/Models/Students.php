<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Students extends Model implements JWTSubject
{
    protected $fillable = [
        'name',
        'email',
        'symbol_number',
        'photo',
        'phone_number',
        'subject',
        'administrator',
        'date_of_birth'
    ];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function attempts()
    {
        return $this->hasMany(StudentAttempt::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'symbol_number' => $this->symbol_number,
            'date_of_birth' => $this->date_of_birth
        ];
    }
}
