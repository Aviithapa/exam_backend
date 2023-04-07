<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentCreateRequest;
use App\Http\Requests\Student\StudentUpdateRequest;
use App\Http\Resources\Student\StudentResource;
use App\Imports\StudentImport;
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
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    //
    use ApiResponser;

    public function index(StudentGetter $studentGetter)
    {
        return StudentResource::collection($studentGetter->getPaginatedList());
    }

    public function store(Request $request, StudentCreator $studentCreator): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:students',
            'symbol_number' => 'required|string|max:255',
            'photo' => 'required|file|mimes:jpg,png,jpeg|max:5000',
            'phone_number' => 'required|string|max:10|min:10|unique:students',
            'date_of_birth' => 'required|string|max:255'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 401);
        
        }
        $data = [];
        $data['name'] = $request->name; 
        $data['email'] = $request->email;
        $data['symbol_number'] = $request->symbol_number;
        $data['phone_number'] = $request->phone_number;
        $data['date_of_birth'] = $request->date_of_birth;
    
        $destinationPath = 'images';
        $myimage = time(). '.'.$request->file('photo')->getClientOriginalName();
        $request->file('photo')->storeAs($destinationPath, $myimage, 'public');
        $data['photo'] = $myimage;
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
            $questionType = $cellValues[3];

            // Create the question
            $question = Question::create([
                'question_text' => $questionText,
                'question_type' => $questionType,
            ]);

            // Get the options data
            $optionsData = array_slice($cellValues, 1, 3);


            // Loop through the options data
            foreach ($optionsData as $optionData) {

                if (is_array($optionData)) {
                    // Create the option
                    $option = Option::create([
                        'option_text' => $optionData[0],
                        'is_correct' => $optionData[1],
                    ]);

                    // Associate the option with the question
                    $question->options()->save($option);
                }
            }
        }

        // Delete the temporary file
        Storage::delete($filePath);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Questions imported successfully.');
    }

    public function verify_student(Request $request, StudentGetter $studentGetter){
        $validator= Validator::make($request->all(), [
            'symbol_number' => 'required|string|max:255',
            'date_of_birth' => 'required|string|max:255',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 401);
        }
        $data= $studentGetter->bySnDob($request->symbol_number, $request->date_of_birth);
        if($data){
            return response()->json([
                'status' => 200,
                'message' => 'Student Exists',
                'student' => $data,
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'Student does not exist',
                
            ]);
        }

    }

    

}
