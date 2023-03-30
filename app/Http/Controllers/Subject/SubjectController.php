<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponser;
use App\Http\Requests\Subject\SubjectCreateRequest;
use App\Http\Requests\Subject\SubjectUpdateRequest;
use App\Http\Resources\Subject\SubjectResource;
use App\Services\Subject\SubjectCreator;
use App\Services\Subject\SubjectGetter;
use App\Services\Subject\SubjectUpdater;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SubjectController extends Controller
{
    use ApiResponser;

    public function index(SubjectGetter $subjectGetter)
    {
        return SubjectResource::collection($subjectGetter->getPaginatedList());
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

    public function destroy(SubjectUpdater $subjectUpdater, $id)
    {
        return $subjectUpdater->delete($id);
    }

    public function update(SubjectUpdateRequest $subjectUpdateRequest,  SubjectUpdater $subjectUpdater, $id)
    {
        $data = $subjectUpdateRequest->all();
        return $this->successResponse(
            SubjectResource::make($subjectUpdater->update($data, $id)),
            __('Subject updated successfully'),
            Response::HTTP_CREATED
        );
    }
}
