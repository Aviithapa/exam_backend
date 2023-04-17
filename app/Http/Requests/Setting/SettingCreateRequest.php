<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SettingCreateRequest extends FormRequest
{

    /**
     * rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'number_of_question_per_student' => ['required', 'integer', 'max:255'],
            'exam_time' => ['required', 'string', 'max:255'],
            'marks_per_question' => ['required', 'string', 'max:255'],
            'passing_mark' => ['required', 'string', 'max:255'],
            'is_negative_marking' => ['required', 'boolean', 'max:255'],
            'negative_marking_per_question' => ['required_if:is_negative_marking,true', 'string', 'max:255'],
            'an_option_right_marking' => ['required', 'boolean', 'max:255'],
        ];
    }
}
