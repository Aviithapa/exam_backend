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
}
