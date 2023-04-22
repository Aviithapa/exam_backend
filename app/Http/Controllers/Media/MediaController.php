<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\CreateMediaRequest as MediaCreateMediaRequest;
use App\Http\Requests\Setting\CreateMediaRequest;
use App\Http\Requests\Setting\SettingCreateRequest;
use App\Http\Resources\Setting\SettingResource;
use App\Services\Media\MediaCreator;
use App\Services\Setting\SettingCreator;
use App\Services\Setting\SettingGetter;
use App\Services\Setting\SettingUpdator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;

class MediaController extends Controller
{
    //
    use ApiResponser;

    public function index(SettingGetter $settingGetter)
    {
        return $settingGetter->get();
    }

    public function store(MediaCreateMediaRequest $request, MediaCreator $mediaCreator)
    {
        return $this->successResponse(
            SettingResource::make($mediaCreator->store($request)),
            __('Image created successfully'),
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
