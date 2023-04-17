<?php

namespace App\Services\Setting;

use App\Repositories\Setting\SettingRepository;
use App\Repositories\Student\StudentRepository;
use Illuminate\Http\Request;
use App\Repositories\Subject\SubjectRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

/**
 * Class ApartmentGetter
 * @package App\Services\Apartment
 */
class SettingGetter
{
    /**
     * @var SettingRepository
     */
    protected $settingRepository;

    /**
     * StudentGetter constructor.
     * @param SettingRepository $settingRepository
     */
    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * Get paginated apartment list
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getPaginatedList(): LengthAwarePaginator
    {
        return $this->settingRepository->getWithPagination();
    }

    /**
     * Get a single apartment
     * @param $id
     * @return Object|null
     */
    public function show($id)
    {
        return $this->settingRepository->getAll()->where('created_by', $id);
    }

    public function get()
    {
        return $this->settingRepository->getAll()->where('created_by', Auth::user()->id)->first();
    }
}
