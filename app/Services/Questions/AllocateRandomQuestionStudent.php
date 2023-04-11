<?php

namespace App\Services\Questions;

use App\Http\Resources\StudentAttempt\StudentAttemptResource;
use App\Models\Question;
use App\Models\StudentAttempt;
use App\Repositories\Questions\QuestionsRepository;
use App\Repositories\Student\StudentRepository;
use App\Repositories\StudentAttempt\StudentAttemptRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class ApartmentGetter
 * @package App\Services\Apartment
 */
class AllocateRandomQuestionStudent
{
    /**
     * @var QuestionsRepository, StudentAttemptsRepository, StudentsRepository
     */
    protected $questionRepository, $studentAttemptRepository, $studentRepository;

    /**
     * StudentGetter constructor.
     * @param QuestionsRepository $questionRepository
     */
    public function __construct(QuestionsRepository $questionRepository, StudentAttemptRepository $studentAttemptRepository, StudentRepository $studentRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->studentAttemptRepository = $studentAttemptRepository;
        $this->studentRepository = $studentRepository;
    }

    /**
     * Get paginated apartment list
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function storeRandomQuestionsForStudents($subjectId)
    {

        $questions = $this->questionRepository->getAll()->where('subject_id', $subjectId);

        $students = $this->studentRepository->getAll()->where('subject_id', $subjectId);

        $questions = $questions->shuffle();
        foreach ($students as $student) {
            $allocatedQuestions = $questions->splice(0, 100);
            foreach ($allocatedQuestions as $allocatedQuestion) {
                $data['student_id'] = $student->id;
                $data['question_id'] = $allocatedQuestion->id;
                $attempt = $this->studentAttemptRepository->create($data);
            }
        }

        return $questions;
    }
}
