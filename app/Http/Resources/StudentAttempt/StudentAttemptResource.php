<?php

namespace App\Http\Resources\StudentAttempt;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentAttemptResource extends JsonResource
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
            "id"      => $this->id,
            "question" => $this->question,
            "student"  => $this->student,
            "attempted_options" => $this->options,
            "correct_answer" => $this->question->correctAnswers,
            "is_answered" => $this->is_answered,
            "options" => $this->question->options,
        ];
    }
}
