<?php

namespace App\Services\Subject;

use App\Repositories\Subject\SubjectRepository;
use Exception;

class SubjectUpdator
{
    protected $subjectRepository;

    public function __construct(SubjectRepository $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }



    public function delete($id)
    {
        return $this->subjectRepository->delete($id);
    }

    public function update($data, $id)
    {
        try {
            return $this->subjectRepository->update($data, $id);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
