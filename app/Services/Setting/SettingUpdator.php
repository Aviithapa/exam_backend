<?php

namespace App\Services\Setting;

use App\Repositories\Setting\SettingRepository;
use App\Repositories\Student\StudentRepository;
use Carbon\Carbon;
use Exception;

class SettingUpdator
{
    protected $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function delete($id)
    {
        return $this->settingRepository->delete($id);
    }

    public function update($data, $id)
    {
        return $this->settingRepository->update($data, $id);
    }
}
