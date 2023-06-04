<?php

namespace App\Services\Questions;

use App\Models\CorrectAnswer;
use App\Repositories\Option\OptionRepository;
use App\Repositories\Questions\QuestionsRepository;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Class ApartmentGetter
 * @package App\Services\Apartment
 */
class QuestionsImports
{
    /**
     * @var QuestionsRepository
     */
    protected $questionRepository, $optionRepository;

    /**
     * StudentGetter constructor.
     * @param QuestionsRepository $questionRepository
     */
    public function __construct(QuestionsRepository $questionRepository, OptionRepository $optionRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->optionRepository = $optionRepository;
    }

    public function importQuestions($data)
    {
        // Get the file path
        $file = $data['file'];
        // dd($data['subject_id']);
        $subjectId = $data['subject_id'];
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

            $questionData['question_text'] = $questionText;
            $questionData['question_type'] = $questionType;
            $questionData['subject_id'] = $subjectId;
            // Create the question
            $question = $this->questionRepository->create($questionData);

            // Get the options data
            $optionsData = array_slice($cellValues, 3);

            $correctAnswerData = $cellValues[2];
            // Loop through the options data
            foreach ($optionsData as $optionData) {
                // Create the option
                $optionDatas['option_text'] = $optionData;
                $option = $this->optionRepository->create($optionDatas);

                // Associate the option with the question
                $question->options()->save($option);
            }

            if ($questionType === 'radio') {

                $correctAnswer = $cellValues[$correctAnswerData];
                $option = $this->optionRepository->getAll()->where('question_id', $question->id)
                    ->where('option_text', $correctAnswer)
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

                    $correctAnswerData = $cellValues[$correctAnswer];
                    $option = $this->optionRepository->getAll()->where('question_id', $question->id)
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
                }
            }
        }

        // Delete the temporary file
        Storage::delete($filePath);

        // Redirect back with success message
        return $question;
    }
}
