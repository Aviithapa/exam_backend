<?php

namespace App\Http\Requests\Questions;

use Illuminate\Foundation\Http\FormRequest;

class ImportFromExcelQuestionRequest extends FormRequest
{

    /**
     * rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'file' => 'required|file|max:2048|mimes:xls,xlsx', // Define the validation rule for the 'file' field as Excel file
            'subject_id' => 'required'
        ];
    }
}
