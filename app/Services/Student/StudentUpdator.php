<?php

namespace App\Services\Student;

use App\Repositories\Student\StudentRepository;
use Exception;

class StudentUpdator
{
    protected $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function delete($id)
    {
        return $this->studentRepository->delete($id);
    }

    public function update($data, $id)
    {
        try {
            return $this->studentRepository->update($data, $id);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
