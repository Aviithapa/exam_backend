<?php

namespace App\Repositories\Subject;

use App\Repositories\Repository;
use Illuminate\Http\Request;

interface SubjectRepository  extends  Repository
{
    public function getPaginatedList(Request $request);
}
