<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // dd($credentials);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $roles = $user->roles;
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'token' => $token,
                'user' => $user,
                'role' => $roles,

            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
