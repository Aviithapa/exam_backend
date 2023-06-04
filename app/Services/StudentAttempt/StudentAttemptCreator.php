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

            $attempt->options()->detach();

            foreach ($optionIds as $optionId) {
                if (!$attempt->options->contains($optionId)) {
                    $attempt->options()->attach($optionId);
                }
            }
        }

        return response()->json(['message' => 'Attempt stored successfully'], 201);
    }


    public function storeMultipleQuestionAnswer($data)
    {


        $studentId = $data['student_id'];
        $questionOptions = $data['data'];
        // dd($questionOptions);

        foreach ($questionOptions as $key => $optionIds) {
            if (isset($optionIds)) {
                $attempt = $this->studentAttemptRepository->getAll()->where('student_id', $studentId)->where('question_id', $key)->first();
                if ($attempt) {

                    $this->studentAttemptRepository->update(['is_answered' => true], $attempt->id);

                    $attempt->options()->detach();

                    // Check if $optionIds is defined
                    if (is_array($optionIds) || is_object($optionIds)) {
                        foreach ($optionIds as $optionId) {
                            if (!$attempt->options->contains($optionId)) {
                                $attempt->options()->attach($optionId);
                            }
                        }
                    } else {
                        if (!$attempt->options->contains($optionIds)) {
                            $attempt->options()->attach($optionIds);
                        }
                    }
                }
            }
        }

        return response()->json(['data' => $questionOptions], 201);
    }
}
