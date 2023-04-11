<?php

namespace App\Http\Controllers\Questions;

use App\Http\Controllers\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Questions\ImportFromExcelQuestionRequest;
use App\Http\Requests\Questions\RandomQuestionRequest;
use App\Http\Requests\Student\StudentCreateRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Http\Resources\Questions\QuestionsResource;
use App\Http\Resources\Student\StudentResource;
use App\Imports\StudentImport;
use App\Models\CorrectAnswer;
use App\Models\Option;
use App\Models\Question;
use App\Services\Questions\AllocateRandomQuestionStudent;
use App\Services\Questions\QuestionsGetter;
use App\Services\Questions\QuestionsImports;
use App\Services\Questions\StudentQuestionGetter;
use App\Services\Student\StudentCreator;
use App\Services\Student\StudentGetter;
use App\Services\Student\StudentUpdator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


class QuestionsController extends Controller
{
    //
    use ApiResponser;

    public function index(QuestionsGetter $questionGetter)
    {
        return QuestionsResource::collection($questionGetter->getPaginatedList());
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

    public function importQuestions(ImportFromExcelQuestionRequest $request, QuestionsImports $questionsImports)
    {
        $data = $request->all();
        return $this->successResponse(
            QuestionsResource::make($questionsImports->importQuestions($data)),
            __('Question imported successfully'),
            Response::HTTP_CREATED
        );
    }

    public function getRandomQuestion($subjectId, StudentQuestionGetter $studentQuestionGetter)
    {

        return $this->successResponse(
            QuestionsResource::collection($studentQuestionGetter->getRandomQuestionsForStudents($subjectId)),
            __('Random Question Fetched Successfully'),
            Response::HTTP_CREATED
        );
    }

    public function getQuestionBasedOnSubject($id, QuestionsGetter $questionGetter)
    {
        return QuestionsResource::collection($questionGetter->getQuestionBasedOnSubject($id));
    }

    public function allocateRandomQuestion(Request $request, AllocateRandomQuestionStudent $allocateRandomQuestionStudent)
    {
        $data = $request->all();

        return QuestionsResource::collection($allocateRandomQuestionStudent->storeRandomQuestionsForStudents($data['subject_id']));
    }
}
