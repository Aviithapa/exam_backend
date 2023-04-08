<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'created_by'
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
