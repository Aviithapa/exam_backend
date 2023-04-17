<?php

namespace App\Services\Setting;

use App\Repositories\Setting\SettingRepository;
use Illuminate\Support\Facades\Auth;

class SettingCreator
{
    protected $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function store($data)
    {
        $data['created_by'] = Auth::user()->id;
        $data['active'] = true;
        $check = $this->settingRepository->getAll()->where('created_by', $data['created_by'])->first();
        if ($check) {
            return $this->settingRepository->update($data, $check->id);
        }
        return $this->settingRepository->create($data);
    }
}
