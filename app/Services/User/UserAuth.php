<?php

namespace App\Services\User;

// use App\Models\Role;
// use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserAuth
{
    
    public function authenticate_user($data)
    {
        return $token = Auth::attempt($data);
        
    }

    
}
