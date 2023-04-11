<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'question_type',
        'subject_id'
    ];

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function correctAnswers()
    {
        return $this->hasMany(CorrectAnswer::class);
    }

    public function attempt()
    {
        return $this->belongsToMany(StudentAttempt::class, 'student_attempt', 'question_id', 'student_id')
            ->withTimestamps();
    }
}
