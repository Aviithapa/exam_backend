<?php

namespace App\Services\Student;

use App\Repositories\Setting\SettingRepository;
use App\Repositories\Student\StudentRepository;
use Illuminate\Http\Request;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Backup\BackupFacade;

/**
 * Class ApartmentGetter
 * @package App\Services\Apartment
 */
class StudentResult
{
    /**
     * @var StudentRepository
     */
    protected $studentRepository, $subjectRepository, $settingRepository;

    /**
     * StudentGetter constructor.
     * @param StudentRepository $studentRepository
     */
    public function __construct(StudentRepository $studentRepository, SubjectRepository $subjectRepository, SettingRepository $settingRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->subjectRepository = $subjectRepository;
        $this->settingRepository = $settingRepository;
    }

    /**
     * Get paginated apartment list
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getPaginatedList(): LengthAwarePaginator
    {
        return $this->studentRepository->getWithPagination();
    }

    public function calculateStudentMarks($studentId)
    {

        $student = $this->studentRepository->findById($studentId);
        $subject = $this->subjectRepository->findById($student->subject_id);
        $settings  =  $this->settingRepository->findByFirst('created_by', $subject->created_by, '=');
        $marks =
            DB::table('attempt_option')
            ->join('student_attempts', 'attempt_option.attempt_id', '=', 'student_attempts.id')
            ->join('correct_answers', function ($join) {
                $join->on('student_attempts.question_id', '=', 'correct_answers.question_id')
                    ->on('attempt_option.option_id', '=', 'correct_answers.option_id');
            })
            ->where('student_attempts.student_id', $studentId)
            ->select('student_attempts.question_id', DB::raw('COUNT(*) as count'))
            ->groupBy('student_attempts.question_id')
            ->get();

        $totalMarksObtained = 0;
        foreach ($marks as $attemptedOption) {
            $questionId = $attemptedOption->question_id;
            $attemptedCount = $attemptedOption->count;
            $correctCount = DB::table('correct_answers')
                ->where('question_id', $questionId)
                ->count();



            // Calculate the marks for each question
            if ($attemptedCount == 0) {
                // If no correct answers are selected, no marks are allocated
                $marksObtained = 0;
            } elseif ($attemptedCount == $correctCount) {
                // If all correct answers are selected, 1 mark is allocated
                $marksObtained = $settings->marks_per_question;
            } else {
                // If some correct answers are selected, 0.5 marks are allocated
                if ($settings->an_option_right_marking)
                    $marksObtained = $settings->marks_per_question * $attemptedCount  / $correctCount;
            }

            $totalMarksObtained += $marksObtained;
        }
        $data['marks'] = $totalMarksObtained;
        $data['status'] = $totalMarksObtained >= $settings->passing_mark ? 'PASSED' : 'FAILED';
        $this->studentRepository->update($data, $studentId);
        return $totalMarksObtained;
    }
}
