<?php

namespace App\Services\Questions;

use App\Repositories\Questions\QuestionsRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class ApartmentGetter
 * @package App\Services\Apartment
 */
class QuestionsGetter
{
    /**
     * @var QuestionsRepository
     */
    protected $questionRepository;

    /**
     * StudentGetter constructor.
     * @param QuestionsRepository $questionRepository
     */
    public function __construct(QuestionsRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * Get paginated apartment list
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getPaginatedList(): LengthAwarePaginator
    {
        return $this->questionRepository->getWithPagination();
    }

    /**
     * Get a single apartment
     * @param $id
     * @return Object|null
     */
    public function show($id)
    {
        return $this->questionRepository->findById($id);
    }

    public function getQuestionBasedOnSubject(Request $request, $id): LengthAwarePaginator
    {
        return $this->questionRepository->getQuestionBasedOnSubject($request, $id);
    }
}
