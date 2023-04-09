<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Students;
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

    public function generateToken(Request $request)
    {
        $symbolNumber = $request->input('symbol_number');
        $dateOfBirth = $request->input('date_of_birth');

        // Retrieve the user from the database based on the symbol_number and date_of_birth
        $user = Students::where('symbol_number', $symbolNumber)
            ->where('date_of_birth', $dateOfBirth)
            ->first();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        // If the user is found, generate the JWT token
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }
}
