<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'question_id',
        'option_id',
        'is_answered'
    ];

    public function student()
    {
        return $this->belongsTo(Students::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function options()
    {
        return $this->belongsToMany(Option::class, 'attempt_option', 'attempt_id', 'option_id')
            ->withTimestamps();
    }

    public function attempt()
    {
        return $this->belongsToMany(StudentAttempt::class, 'attempt_option', 'attempt_id', 'option_id')
            ->withTimestamps();
    }

    public function correctAnswer()
    {
        return $this->belongsToMany(Question::class, 'correct_answers', 'question_id', 'option_id')
            ->withTimestamps();
    }
}
