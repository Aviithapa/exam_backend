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
        'subject_id',
        'is_terms_and_condition_accepted',
        'start_time',
        'end_time',
        'photo_while_starting_exam',
        'marks',
        'status'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function attempt()
    {
        return $this->belongsToMany(StudentAttempt::class, 'student_attempts', 'question_id', 'student_id')
            ->withTimestamps();
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

    public function question()
    {
        return $this->belongsToMany(Question::class);
    }
}
