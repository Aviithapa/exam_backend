<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{

    /**
     * rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'min:8'],
            'new_password' => ['required', 'min:8'],
        ];
    }
}
