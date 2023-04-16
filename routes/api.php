<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Questions\QuestionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\StudentAttempt\StudentAttemptController;
use App\Http\Controllers\Subject\SubjectController;
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


// Route::apiResource('/users', UserController::class)->only(
//     'index',
//     'store',
//     'show',
//     'destroy',
//     'update'
// );



// Route::apiResource('/questions', QuestionsController::class);


Route::get('/getStudentBasedOnSubject/{subjectId}', [StudentController::class, 'getStudentBasedOnSubject']);

Route::post('/allocateRandomQuestion', [QuestionsController::class, 'allocateRandomQuestion']);
Route::middleware(['auth:api'])->group(
    function () {
        Route::apiResource('/roles', RoleController::class);
        Route::apiResource('/questions', QuestionsController::class);
        Route::apiResource('/users', UserController::class);
        Route::post('/importStudents', [StudentController::class, 'importStudent']);
        Route::apiResource('/subject', SubjectController::class);
        Route::post('/importSubject', [SubjectController::class, 'importSubject']);
        Route::post('/importQuestions', [QuestionsController::class, 'importQuestions']);
    }
);
Route::apiResource('/attempts', StudentAttemptController::class);

Route::get('/getRandomQuestion/{subjectId}', [QuestionsController::class, 'getRandomQuestion']);
Route::middleware(['jwt.student.verify'])->group(
    function () {
        Route::apiResource('/attempt', StudentAttemptController::class);
        Route::apiResource('/student', StudentController::class);
        Route::get('/getQuestionBasedOnSubject/{subjectId}', [QuestionsController::class, 'getQuestionBasedOnSubject']);
    }
);

Route::post('/generateToken', [AuthController::class, 'generateToken']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware(['auth:api']);
Route::post('/auth/password-change', [AuthController::class, 'changePassword'])->middleware(['auth:api']);
Route::match(['post', 'get'], '/login', [AuthController::class, 'login'])->name('login');
// Route::post('/auth/refresh-token', 'AuthController@refreshToken');
Route::get('/calculateStudentMarks/{studentId}', [StudentController::class, 'calculateStudentMarks']);
