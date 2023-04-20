<?php

namespace App\Services\Questions;

use App\Models\Question;
use App\Repositories\Questions\QuestionsRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class ApartmentGetter
 * @package App\Services\Apartment
 */
class StudentQuestionGetter
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
    public function getRandomQuestionsForStudents($subjectId)
    {

        $question = Question::orderByRaw('RAND()')->take(30)->get();
        return $question;
    }
}
