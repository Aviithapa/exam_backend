<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponser;
use App\Http\Requests\Subject\SubjectCreateRequest;
use App\Http\Requests\Subject\SubjectUpdateRequest;
use App\Http\Resources\Subject\SubjectResource;
use App\Imports\StudentImport;
use App\Imports\SubjectImport;
use App\Services\Subject\SubjectCreator;
use App\Services\Subject\SubjectGetter;
use App\Services\Subject\SubjectUpdater;
use App\Services\Subject\SubjectUpdator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SubjectController extends Controller
{
    use ApiResponser;

    public function index(Request $request, SubjectGetter $subjectGetter)
    {
        return SubjectResource::collection($subjectGetter->getPaginatedList($request));
    }

    public function store(SubjectCreateRequest $request, SubjectCreator $subjectCreator): JsonResponse
    {
        $data = $request->all();
        return $this->successResponse(
            SubjectResource::make($subjectCreator->store($data)),
            __('Subject created successfully'),
            Response::HTTP_CREATED
        );
    }

    public function show(SubjectGetter $subjectGetter, $id)
    {
        return $this->successResponse(SubjectResource::make($subjectGetter->show($id)));
    }

    public function destroy(SubjectUpdator $subjectUpdater, $id)
    {
        $subject = $subjectUpdater->delete($id);
        return $this->successResponse(
            $subject,
            __('Subject deleted successfully'),
            Response::HTTP_ACCEPTED
        );
    }

    public function update(SubjectUpdateRequest $subjectUpdateRequest,  SubjectUpdator $subjectUpdater, $id)
    {
        $data = $subjectUpdateRequest->all();
        return $this->successResponse(
            SubjectResource::make($subjectUpdater->update($data, $id)),
            __('Subject updated successfully'),
            Response::HTTP_CREATED
        );
    }

    public function importSubject(Request $request)
    {

        Excel::import(new  SubjectImport(), $request->file('file')->store('temp'));
        return $this->successResponse(
            __('Subject import successfully'),
            Response::HTTP_CREATED
        );
    }
}
