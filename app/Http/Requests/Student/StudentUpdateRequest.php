<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
{

    /**
     * rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'email' => ['string', 'max:255', 'unique:students'],
            'symbol_number' => ['string', 'max:255'],
            'photo' => ['string', 'max:255'],
            'phone_number' => ['string', 'max:255'],
            'subject' => ['string', 'max:255'],
            'administrator' => ['string', 'max:255'],
            'date_of_birth' => ['string', 'max:255']
        ];
    }
}
