<?php

namespace App\Repositories\StudentAttempt;

use App\Models\StudentAttempt;
use App\Repositories\RepositoryImplementation;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentStudentAttemptRepository extends RepositoryImplementation implements StudentAttemptRepository
{

    public function getModel()
    {
        return new StudentAttempt();
    }

    public function getPaginatedList(Request $request, array $columns = array('*')): LengthAwarePaginator
    {
        $limit = $request->get('limit', config('app.per_page'));
        return $this->getModel()->newQuery()
            ->latest()
            ->paginate($limit);
    }
}
