<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Services\User\UserCreator;
use App\Services\User\UserAuth;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request, UserAuth $userAuth)
    {
        $validator= Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 401);
        
        }
        $credentials = $request->only('email', 'password');

        $token = $userAuth->authenticate_user($credentials);
        if (!$token) {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
                'status' => 200,
                'message' => 'Login Successful',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }

    public function register(Request $request, UserCreator $userCreator){
        $validator= Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone_number'=>'required|unique:users',
            'role' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 401);
        
        }

        $data = [];
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = bcrypt($request->password);
        $data['phone_number'] = $request->phone_number;
        $data['role'] = $request->role;

        $user = $userCreator->store($data);

        $token = Auth::login($user);
        return response()->json([
            'status' => 200,
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
        // return $this->successResponse(
        //     UserResource::make(['data'=>$userCreator->store($data), 'token'=>$token]),
        //     __('User created successfully'),
        //     Response::HTTP_CREATED
        // );
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
