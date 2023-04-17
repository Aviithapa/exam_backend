<?php

namespace App\Repositories\Setting;

use App\Models\Setting;
use App\Models\Students;
use App\Repositories\RepositoryImplementation;
use App\Repositories\Setting\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentSettingRepository extends RepositoryImplementation implements SettingRepository
{

    public function getModel()
    {
        return new Setting();
    }

    public function getPaginatedList(Request $request, array $columns = array('*')): LengthAwarePaginator
    {
        $limit = $request->get('limit', config('app.per_page'));
        return $this->getModel()->newQuery()
            ->latest()
            ->paginate($limit);
    }
}
