<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\User\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware'=>'api'], function($routes){
    Route::post('/login', [AuthController::class, 'login']);
    
});
Route::group(['middleware'=>'auth:api'], function($routes){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/student/verify', [StudentController::class, 'verify_student']);
    Route::post('/student/create', [StudentController::class, 'store']);
    Route::post('/student/create/role/{$userId}/{$role}', [UserController::class, 'create_user_role']);
    Route::post('/student/get/role/{$userId}', [UserController::class, 'get_user_role']);
});
    