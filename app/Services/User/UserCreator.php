<?php

namespace App\Services\User;

use App\Mail\RegistrarUser;
use App\Models\Role;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Mail;

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
        Mail::to($user->email)->send(new RegistrarUser($user));
        return $user;
    }
}
