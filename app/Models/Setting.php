<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;



    protected $fillable = [
        'number_of_question_per_student',
        'exam_time',
        'marks_per_question',
        'passing_mark',
        'is_negative_marking',
        'negative_marking_per_question',
        'an_option_right_marking',
        'created_by',
        'active'
    ];
}
