<?php

namespace App\Repositories\Questions;

use App\Models\Question;
use App\Repositories\RepositoryImplementation;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentQuestionsRepository extends RepositoryImplementation implements QuestionsRepository
{

    public function getModel()
    {
        return new Question();
    }

    public function getPaginatedList(Request $request, array $columns = array('*')): LengthAwarePaginator
    {
        $limit = $request->get('limit', config('app.per_page'));
        return $this->getModel()->newQuery()
            ->latest()
            ->paginate($limit);
    }

    public function getRandomQuestions($count = 2)
    {
        // Retrieve a random set of questions from the questions table
        return $this->getModel()->orderByRaw('RAND()')->take($count)->get();
    }
}
