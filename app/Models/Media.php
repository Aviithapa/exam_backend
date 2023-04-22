<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'medias';
    protected $fillable = [
        'student_id',
        'image_type',
        'image_name',
    ];

    public function student()
    {
        return $this->belongsTo(Students::class);
    }
}
