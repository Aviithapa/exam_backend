<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Students;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $dateOfBirth =  $request->input('date_of_birth');

        // Retrieve the user from the database based on the symbol_number and date_of_birth
        $user = Students::where('symbol_number', $symbolNumber)
            ->where('date_of_birth', $dateOfBirth)
            ->first();

        // dd($user);
        if (!$user) {
            return response()->json(['error' => 'Unauthorized or No Student found'], 401);
        }


        // If the user is found, generate the JWT token
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function refreshToken(Request $request)
    {
        try {
            // Get the refresh token from the request
            $refreshToken = $request->input('refresh_token');

            // Attempt to refresh the JWT token
            $token = JWTAuth::refresh($refreshToken);

            // Return the new token as a response
            return response()->json([
                'status' => 'success',
                'token' => $token
            ]);
        } catch (\Exception $e) {
            // Handle any errors that occurred during token refresh
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to refresh token'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {

            // Invalidate the JWT token
            JWTAuth::invalidate(JWTAuth::getToken());

            // Return a success response
            return response()->json([
                'status' => 'success',
                'message' => 'Logged out successfully'
            ]);
        } catch (\Exception $e) {
            // Handle any errors that occurred during logout
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to logout'
            ], 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {

            $id = Auth::user()->id;
            // Find the user by email
            $user = User::where('id', $id)->first();

            // If user not found, return an error response
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            if (Hash::check($request->password, $user->password)) {
                $user->update([
                    'password' => bcrypt($request->new_password)
                ]);
                // JWTAuth::invalidate(JWTAuth::getToken());
                return response()->json(['message' => 'Password reset successful']);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Old Password Doesnot Match'
            ], 404);
        } catch (\Exception $e) {
            // Handle any errors that occurred during token refresh
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to refresh token'
            ], 500);
        }
    }
}
