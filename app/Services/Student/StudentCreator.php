<?php

namespace App\Services\Student;

use App\Repositories\Student\StudentRepository;
use App\Models\Subjects;

class StudentCreator
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
