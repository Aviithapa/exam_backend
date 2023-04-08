<?php

namespace App\Services\StudentAttempt;

use App\Repositories\Student\StudentRepository;
use App\Repositories\StudentAttempt\StudentAttemptRepository;
use Illuminate\Http\Request;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class ApartmentGetter
 * @package App\Services\Apartment
 */
class StudentAttemptGetter
{
    /**
     * @var StudentAttemptRepository
     */
    protected $studentAttemptRepository;

    /**
     * StudentGetter constructor.
     * @param StudentAttemptRepository $studentRepository
     */
    public function __construct(StudentAttemptRepository $studentAttemptRepository)
    {
        $this->studentAttemptRepository = $studentAttemptRepository;
    }

    /**
     * Get paginated apartment list
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getPaginatedList(): LengthAwarePaginator
    {
        return $this->studentAttemptRepository->getWithPagination();
    }

    /**
     * Get a single apartment
     * @param $id
     * @return Object|null
     */
    public function show($id)
    {
        return $this->studentAttemptRepository->findById($id);
    }
}
