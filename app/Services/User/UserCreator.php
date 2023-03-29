<?php

namespace App\Services\User;

use App\Models\Role;
use App\Repositories\User\UserRepository;

class UserCreator
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function store($data)
    {
        $role = Role::where('name', $data['role'])->first();
        $user = $this->userRepository->create($data);
        $user->roles()->attach($role);
        return $user;
    }
}
