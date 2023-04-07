<?php

namespace App\Services\User;

use App\Models\Role;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;

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
        $user->roles()->attach($role, ['user_type'=>$data['role']]);
        // $token = Auth::login($user);
        
        return $user;
    }

    public function assign_role($userId, $rol)
    {
        $role = Role::where('name', $rol)->first();
        $user = $this->userRepository->findById($userId);
        $user->roles()->attach($role, ['user_type'=>$rol]);
        return array('user'=>$user, 'role'=>$role);
    }
}
