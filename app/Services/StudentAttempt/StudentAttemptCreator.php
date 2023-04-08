<?php

namespace App\Services\StudentAttempt;

use App\Repositories\Student\StudentRepository;

class StudentAttemptCreator
{
    protected $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function store($data)
    {
        return $this->studentRepository->create($data);
    }
}
