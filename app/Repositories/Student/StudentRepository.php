<?php

namespace App\Repositories\Student;

use App\Repositories\Repository;
use Illuminate\Http\Request;

interface StudentRepository  extends  Repository
{
    public function getPaginatedList(Request $request);
}
