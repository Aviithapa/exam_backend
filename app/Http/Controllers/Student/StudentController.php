<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentCreateRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Http\Resources\Student\StudentResource;
use App\Imports\StudentImport;
use App\Services\Student\StudentCreator;
use App\Services\Student\StudentGetter;
use App\Services\Student\StudentUpdator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;

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

    public function importStudent(Request $request)
    {
        Excel::import(new  StudentImport(), $request->file('file')->store('temp'));
        return $this->successResponse(
            __('Student import successfully'),
            Response::HTTP_CREATED
        );
    }
}
