<?php

namespace App\Http\Resources\Setting;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'number_of_question_per_student' => $this->number_of_question_per_student,
            'exam_time' => $this->exam_time,
            'marks_per_question' => $this->marks_per_question,
            'passing_mark' => $this->passing_mark,
            'is_negative_marking' => $this->is_negative_marking,
            'negative_marking_per_question' => $this->negative_marking_per_question,
            'an_option_right_marking' => $this->an_option_right_marking,
        ];
    }
}
