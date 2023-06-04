<?php

namespace App\Repositories\Questions;

use App\Repositories\Repository;
use Illuminate\Http\Request;

interface QuestionsRepository  extends  Repository
{
    public function getQuestionBasedOnSubject(Request $request, $id);
}
