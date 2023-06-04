<?php

namespace App\Services\Student;

use App\Repositories\Student\StudentRepository;
use Illuminate\Http\Request;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class ApartmentGetter
 * @package App\Services\Apartment
 */
class StudentGetter
{
    /**
     * @var StudentRepository
     */
    protected $studentRepository;

    /**
     * StudentGetter constructor.
     * @param StudentRepository $studentRepository
     */
    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * Get paginated apartment list
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getPaginatedList($request): LengthAwarePaginator
    {
        return $this->studentRepository->getPaginatedList($request);
    }

    /**
     * Get a single apartment
     * @param $id
     * @return Object|null
     */
    public function show($id)
    {
        return $this->studentRepository->findById($id);
    }

    public function getStudentBasedOnSubject($id)
    {
        return $this->studentRepository->getAll()->where('subject_id', $id);
    }
}
