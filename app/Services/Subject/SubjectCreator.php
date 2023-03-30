<?php

namespace App\Services\Subject;

use App\Repositories\Subject\SubjectRepository;

class SubjectCreator
{
    protected $subjectRepository;

    public function __construct(SubjectRepository $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    public function store($data)
    {
        return $this->subjectRepository->create($data);
    }
}
