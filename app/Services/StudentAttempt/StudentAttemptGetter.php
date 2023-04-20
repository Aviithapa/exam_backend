<?php

namespace App\Services\StudentAttempt;

use App\Models\StudentAttempt;
use App\Repositories\StudentAttempt\StudentAttemptRepository;
use Illuminate\Http\Request;
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
    public function getPaginatedList(Request $request): LengthAwarePaginator
    {
        return  $this->studentAttemptRepository->getPaginatedList($request);
    }

    /**
     * Get a single apartment
     * @param $id
     * @return Object|null
     */
    public function show($id)
    {
        return $this->studentAttemptRepository->findBy('student_id', '=',  $id);
    }



    public function pulchockWiseData($request, $id): LengthAwarePaginator
    {
        $results = $this->studentAttemptRepository->pulchockWiseData($request, $id);
        return $results;
    }
}
