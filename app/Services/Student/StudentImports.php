<?php

namespace App\Services\Student;

use App\Models\CorrectAnswer;
use App\Models\Subject;
use App\Repositories\Option\OptionRepository;
use App\Repositories\Questions\QuestionsRepository;
use App\Repositories\Student\StudentRepository;
use App\Repositories\Subject\SubjectRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Class ApartmentGetter
 * @package App\Services\Apartment
 */
class StudentImports
{
    /**
     * @var StudentRepository, SubjectRepository
     */
    protected $studentRepository, $subjectRepository;

    /**
     * StudentImports constructor.
     * @param StudentRepository $studentRepository
     */
    public function __construct(StudentRepository $studentRepository, SubjectRepository $subjectRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->subjectRepository = $subjectRepository;
    }

    public function importStudents($data)
    {
        // Get the file path
        $file = $data['file'];
        $filePath = $file->store('temp');

        // Load the Excel file
        $spreadsheet = IOFactory::load(storage_path('app/' . $filePath));
        $worksheet = $spreadsheet->getActiveSheet();
        $duplicateEmails = [];
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
            $date = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($cellValues[5] - 2)->format('Y-m-d');


            $studentData['name'] = $cellValues[0];
            $studentData['email'] = $cellValues[1];
            $studentData['symbol_number'] = $cellValues[2];
            $studentData['photo'] = $cellValues[3];
            $studentData['phone_number'] = $cellValues[4];
            $studentData['date_of_birth'] = $date;
            $studentData['program'] = $cellValues[6];



            $student = $this->studentRepository->getAll()->where('email', $studentData['email'])->first();


            if (!$student) {
                $program = Subject::where('name', $studentData['program'])->where('created_by', Auth::user()->id)->first();

                if (!$program) {
                    $programData['name'] = $studentData['program'];
                    $programData['display_name'] = $studentData['program'];
                    $programData['created_by'] = Auth::user()->id;
                    $program = $this->subjectRepository->create($programData);
                }


                $studentData['subject_id'] = $program->id;
                $student = $this->studentRepository->create($studentData);
            } else {
                array_push($duplicateEmails, $studentData['email']);
            }
            // Loop through the options data



        }

        // Delete the temporary file
        Storage::delete($filePath);

        // Redirect back with success message
        return $duplicateEmails;
    }
}
