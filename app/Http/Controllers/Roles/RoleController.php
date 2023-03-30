<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiResponser;
use App\Http\Requests\Role\RoleCreateRequest;
use App\Http\Resources\Roles\RoleResource;
use App\Services\Role\RoleCreator;
use App\Services\Role\RoleGetter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    use ApiResponser;

    public function index(RoleGetter $roleGetter)
    {
        return RoleResource::collection($roleGetter->getPaginatedList());
    }

    public function store(RoleCreateRequest $request, RoleCreator $roleCreator): JsonResponse
    {
        $data = $request->all();
        return $this->successResponse(
            RoleResource::make($roleCreator->store($data)),
            __('Role created successfully'),
            Response::HTTP_CREATED
        );
    }

    public function show(RoleGetter $roleGetter, $id)
    {
        return $this->successResponse(RoleResource::make($roleGetter->show($id)));
    }

    // public function destroy(RoleUpdater $roleUpdater, $id)
    // {
    //     return $userUpdater->delete($id);
    // }

    // public function update(RoleUpdateRequest $userUpdateRequest,  UserUpdater $userUpdater, $id)
    // {
    //     $data = $userUpdateRequest->all();
    //     $data['password'] = bcrypt($data['password']);
    //     return $this->successResponse(
    //         UserResource::make($userUpdater->update($data, $id)),
    //         __('User updated successfully'),
    //         Response::HTTP_CREATED
    //     );
    // }
}
