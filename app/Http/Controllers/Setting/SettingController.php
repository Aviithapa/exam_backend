<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\SettingCreateRequest;
use App\Http\Resources\Setting\SettingResource;
use App\Services\Setting\SettingCreator;
use App\Services\Setting\SettingGetter;
use App\Services\Setting\SettingUpdator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SettingController extends Controller
{
    //
    use ApiResponser;

    public function index(SettingGetter $settingGetter)
    {
        return $settingGetter->get();
    }

    public function store(SettingCreateRequest $request, SettingCreator $settingCreator): JsonResponse
    {
        $data = $request->all();
        return $this->successResponse(
            SettingResource::make($settingCreator->store($data)),
            __('Setting created successfully'),
            Response::HTTP_CREATED
        );
    }


    public function update(Request $request,  SettingUpdator $settingUpdater, $id)
    {
        $data = $request->all();
        return $this->successResponse(
            SettingResource::make($settingUpdater->update($data, $id)),
            __('Setting updated successfully'),
            Response::HTTP_CREATED
        );
    }
}
