<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentCreateRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Http\Resources\Student\StudentResource;
use App\Imports\StudentImport;
use App\Models\CorrectAnswer;
use App\Models\Option;
use App\Models\Question;
use App\Services\Student\StudentCreator;
use App\Services\Student\StudentGetter;
use App\Services\Student\StudentImports;
use App\Services\Student\StudentUpdator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class StudentController extends Controller
{
    //
    use ApiResponser;

    public function index(StudentGetter $studentGetter)
    {
        return StudentResource::collection($studentGetter->getPaginatedList());
    }

    public function store(StudentCreateRequest $request, StudentCreator $studentCreator): JsonResponse
    {
        $data = $request->all();
        return $this->successResponse(
            StudentResource::make($studentCreator->store($data)),
            __('Student created successfully'),
            Response::HTTP_CREATED
        );
    }

    public function show(StudentGetter $studentGetter, $id)
    {
        return $this->successResponse(StudentResource::make($studentGetter->show($id)));
    }

    public function destroy(StudentUpdator $studentUpdater, $id)
    {
        $student = $studentUpdater->delete($id);
        return $this->successResponse(
            $student,
            __('Student deleted successfully'),
            Response::HTTP_ACCEPTED
        );
    }

    public function update(StudentUpdateRequest $studentUpdateRequest,  StudentUpdator $studentUpdater, $id)
    {
        $data = $studentUpdateRequest->all();
        return $this->successResponse(
            StudentResource::make($studentUpdater->update($data, $id)),
            __('Student updated successfully'),
            Response::HTTP_CREATED
        );
    }

    public function importStudent(Request $request, StudentImports $studentImports)
    {
        $data = $request->all();
        return $studentImports->importStudents($data);
    }

    public function getStudentBasedOnSubject($id, StudentGetter $studentGetter)
    {
        return StudentResource::collection($studentGetter->getStudentBasedOnSubject($id));
    }

    public function calculateStudentMarks($studentId)
    {
        // Join the attempt_option, student_attempts, and correct_answers tables
        // based on their corresponding foreign keys
        // $marks =
        // DB::table('attempt_option')
        // ->join('student_attempts', 'attempt_option.attempt_id', '=', 'student_attempts.id')
        // ->join('correct_answers', function ($join) {
        //     $join->on('student_attempts.question_id', '=', 'correct_answers.question_id')
        //         ->on('attempt_option.option_id', '=', 'correct_answers.option_id');
        // })
        // ->where('student_attempts.student_id', $studentId)
        // ->get();

        // Retrieve the attempted options and correct answers for each question
        $attemptedOptions = DB::table('attempt_option')
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
        foreach ($attemptedOptions as $attemptedOption) {
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
                $marksObtained = 1;
            } else {
                // If some correct answers are selected, 0.5 marks are allocated
                $marksObtained = 0.5;
            }

            $totalMarksObtained += $marksObtained;
        }

        return $totalMarksObtained;
    }
}
