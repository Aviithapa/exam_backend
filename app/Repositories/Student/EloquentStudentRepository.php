<?php

namespace App\Repositories\Student;

use App\Models\Students;
use App\Repositories\RepositoryImplementation;
use App\Repositories\Student\StudentRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentStudentRepository extends RepositoryImplementation implements StudentRepository
{

    public function getModel()
    {
        return new Students();
    }

    public function getPaginatedList(Request $request, array $columns = array('*')): LengthAwarePaginator
    {
        $limit = $request->get('limit', config('app.per_page'));
        return $this->getModel()->newQuery()
            ->latest()
            ->paginate($limit);
    }

    public function checkBySnDob($sn, $dob){
        return Students::where('symbol_number', $sn)->where('date_of_birth', $dob)->first();
    }
}
