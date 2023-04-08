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
use App\Services\Student\StudentUpdator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    public function importStudent(Request $request)
    {
        Excel::import(new  StudentImport(), $request->file('file')->store('temp'));
        return $this->successResponse(
            __('Student import successfully'),
            Response::HTTP_CREATED
        );
    }

    public function importQuestions(Request $request)
    {
        // Get the file path
        $file = $request->file('file');
        $data = $request->all();
        $filePath = $file->store('temp');

        // Load the Excel file
        $spreadsheet = IOFactory::load(storage_path('app/' . $filePath));
        $worksheet = $spreadsheet->getActiveSheet();

        // Loop through the rows
        foreach ($worksheet->getRowIterator() as $row) {
            // Skip the header row
            if ($row->getRowIndex() == 1) {
                continue;
            }

            // Get the question data
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // Loop through all cells, even empty ones
            $cellValues = [];
            foreach ($cellIterator as $cell) {
                $cellValues[] = $cell->getValue();
            }
            $questionText = $cellValues[0];
            $questionType = $cellValues[1];

            // Create the question
            $question = Question::create([
                'question_text' => $questionText,
                'question_type' => $questionType,
            ]);

            // Get the options data
            $optionsData = array_slice($cellValues, 3);

            $correctAnswerData = $cellValues[2];
            // Loop through the options data
            foreach ($optionsData as $optionData) {
                // Create the option
                $option = Option::create([
                    'option_text' => $optionData,
                ]);

                // Associate the option with the question
                $question->options()->save($option);
            }

            if ($questionType === 'radio') {


                $option = Option::where('question_id', $question->id)
                    ->where('option_text', $correctAnswerData)
                    ->first();

                if ($option) {
                    // Create a new CorrectAnswer model
                    $correctAnswerModel = new CorrectAnswer();
                    $correctAnswerModel->question_id = $question->id;
                    $correctAnswerModel->option_id = $option->id;
                    $correctAnswerModel->save();

                    // Associate the CorrectAnswer with the Question and Option models
                    $question->correctAnswers()->save($correctAnswerModel);
                    $option->correctAnswers()->save($correctAnswerModel);
                }
            } else if ($questionType === 'checkbox') {
                $correctAnswerArray = explode(':', $correctAnswerData);
                foreach ($correctAnswerArray as $correctAnswer) {

                    $correctAnswerWithoutSpaces =
                        str_replace(' ', '', $correctAnswer);
                    $option = Option::where('question_id', $question->id)
                        ->where('option_text', $correctAnswerWithoutSpaces)
                        ->first();


                    if ($option) {
                        // Create a new CorrectAnswer model
                        $correctAnswerModel = new CorrectAnswer();
                        $correctAnswerModel->question_id = $question->id;
                        $correctAnswerModel->option_id = $option->id;
                        $correctAnswerModel->save();

                        // Associate the CorrectAnswer with the Question and Option models
                        $question->correctAnswers()->save($correctAnswerModel);
                        $option->correctAnswers()->save($correctAnswerModel);
                    }
                }
            }
        }

        // Delete the temporary file
        Storage::delete($filePath);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Questions imported successfully.');
    }
}
