<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentCreateRequest extends FormRequest
{

    /**
     * rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:students'],
            'symbol_number' => ['required', 'string', 'max:255'],
            'photo' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'administrator' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'string', 'max:255']
        ];
    }
}
