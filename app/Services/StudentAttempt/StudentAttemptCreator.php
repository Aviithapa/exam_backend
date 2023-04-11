<?php

namespace App\Services\StudentAttempt;

use App\Models\CorrectAnswer;
use App\Models\Option;
use App\Models\Students;
use App\Repositories\StudentAttempt\StudentAttemptRepository;

class StudentAttemptCreator
{
    protected $studentAttemptRepository;

    public function __construct(StudentAttemptRepository $studentAttemptRepository)
    {
        $this->studentAttemptRepository = $studentAttemptRepository;
    }

    public function store($data)
    {

        $optionIds = $data['option_ids'];
        $studentId = $data['student_id'];
        $questionId = $data['question_id'];


        $attempt = $this->studentAttemptRepository->getAll()->where('student_id', $studentId)->where('question_id', $questionId)->first();

        if ($attempt) {
            $this->studentAttemptRepository->update(['is_answered' => true], $attempt->id);
            $attempt->options()->attach($optionIds);
        }
        // Create a new attempt
        // dd($optionIds);

        // Attach selected options to the attempt

        return response()->json(['message' => 'Attempt stored successfully'], 201);
    }
}
