<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
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
}
