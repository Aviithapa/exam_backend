<?php

namespace App\Repositories\StudentAttempt;

use App\Repositories\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface StudentAttemptRepository  extends  Repository
{
    public function pulchockWiseData(Request $request, $id);

    public function getPaginatedList(Request $request, array $columns = array('*'));
}
