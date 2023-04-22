<?php

namespace App\Http\Requests\Media;

use Illuminate\Foundation\Http\FormRequest;

class CreateMediaRequest extends FormRequest
{

    /**
     * rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'photo' => ['required'],
            'student_id' => ['required', 'string', 'max:255'],
            'symbol_number' => ['required', 'string', 'max:255'],
            'image_type' => ['required', 'string', 'max:255'],
        ];
    }
}
