<?php

namespace App\Repositories\Subject;

use App\Models\Subject;
use App\Repositories\RepositoryImplementation;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentSubjectRepository extends RepositoryImplementation implements SubjectRepository
{

    public function getModel()
    {
        return new Subject();
    }

    public function getPaginatedList(Request $request, array $columns = array('*')): LengthAwarePaginator
    {
        $limit = $request->get('limit', config('app.per_page'));
        return $this->getModel()->newQuery()
            ->latest()
            ->paginate($limit);
    }
}
