<?php

namespace App\Services\StudentAttempt;

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
        // Create a new attempt
        // dd($optionIds);
        $attempt
            = $this->studentAttemptRepository->create($data);

        // Attach selected options to the attempt
        $attempt->options()->attach($optionIds);

        return response()->json(['message' => 'Attempt stored successfully'], 201);
    }
}
