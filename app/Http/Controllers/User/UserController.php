<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponser;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Services\User\UserGetter;
use App\Services\User\UserCreator;
use App\Services\User\UserUpdater;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    use ApiResponser;

    public function index(UserGetter $userGetter)
    {
        return UserResource::collection($userGetter->getPaginatedList());
    }

    public function store(UserCreateRequest $request, UserCreator $userCreator): JsonResponse
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        return $this->successResponse(
            UserResource::make($userCreator->store($data)),
            __('User created successfully'),
            Response::HTTP_CREATED
        );
    }

    public function show(UserGetter $userGetter, $id)
    {
        return $this->successResponse(UserResource::make($userGetter->show($id)));
    }

    public function destroy(UserUpdater $userUpdater, $id)
    {
        return $userUpdater->delete($id);
    }

    public function update(UserUpdateRequest $userUpdateRequest,  UserUpdater $userUpdater, $id)
    {
        $data = $userUpdateRequest->all();
        $data['password'] = bcrypt($data['password']);
        return $this->successResponse(
            UserResource::make($userUpdater->update($data, $id)),
            __('User updated successfully'),
            Response::HTTP_CREATED
        );
    }
}
