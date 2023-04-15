<?php

namespace App\Services\Student;

use App\Repositories\Student\StudentRepository;
use Carbon\Carbon;
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
        if (isset($data['start_time'])) {
            // Parse start_time value into a Carbon instance
            $data['start_time'] = Carbon::parse($data['start_time']);
        }
        if (isset($data['end_time'])) {
            // Parse end_time value into a Carbon instance
            $data['end_time'] = Carbon::parse($data['end_time']);
        }
        try {
            return $this->studentRepository->update($data, $id);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
