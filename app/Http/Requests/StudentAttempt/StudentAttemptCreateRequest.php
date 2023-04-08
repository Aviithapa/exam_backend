<?php

namespace App\Http\Requests\StudentAttempt;

use Illuminate\Foundation\Http\FormRequest;

class StudentAttemptCreateRequest extends FormRequest
{

    /**
     * rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'question_id' => 'required|exists:questions,id',
            'option_ids' => 'required|array',
        ];
    }
}
