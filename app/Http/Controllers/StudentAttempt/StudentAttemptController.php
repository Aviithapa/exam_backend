<?php

namespace App\Http\Controllers\StudentAttempt;

use App\Http\Controllers\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentCreateRequest;
use App\Http\Requests\StudentAttempt\StudentAttemptCreateRequest;
use App\Http\Resources\StudentAttempt\StudentAttemptResource;
use App\Http\Resources\Student\StudentResource;
use App\Services\Student\StudentCreator;
use App\Services\Student\StudentGetter;
use App\Services\Student\StudentUpdator;
use App\Services\StudentAttempt\StudentAttemptCreator;
use App\Services\StudentAttempt\StudentAttemptGetter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class StudentAttemptController extends Controller
{
    //
    use ApiResponser;


    public function index(StudentAttemptGetter $studentGetter)
    {
        return StudentAttemptResource::collection($studentGetter->getPaginatedList());
    }

    public function store(StudentAttemptCreateRequest $request, StudentAttemptCreator $studentAttemptCreator): JsonResponse
    {
        $data = $request->all();
        return $studentAttemptCreator->store($data);
    }

    public function show(StudentAttemptGetter $studentGetter, $id)
    {
        return StudentAttemptResource::collection($studentGetter->show($id));
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

    public function pulchockWiseData(StudentAttemptGetter $studentGetter, $id)
    {
        return StudentAttemptResource::collection($studentGetter->pulchockWiseData($id));
    }
}
