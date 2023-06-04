<?php

namespace App\Http\Controllers\Student;

use App\Exports\StudentsExport;
use App\Http\Controllers\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentCreateRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Http\Resources\Student\StudentResource;
use App\Services\Student\StudentCreator;
use App\Services\Student\StudentGetter;
use App\Services\Student\StudentImports;
use App\Services\Student\StudentResult;
use App\Services\Student\StudentUpdator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    //
    use ApiResponser;

    public function index(Request $request, StudentGetter $studentGetter)
    {
        return StudentResource::collection($studentGetter->getPaginatedList($request));
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

    public function calculateStudentMarks($studentId, StudentResult $studentResult)
    {
        // Join the attempt_option, student_attempts, and correct_answers tables
        // based on their corresponding foreign keys
        return $studentResult->calculateStudentMarks($studentId);
    }

    public function exportStudentsToExcel()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
    }
}
