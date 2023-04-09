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
        'date_of_birth',
        'subject_id'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
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
