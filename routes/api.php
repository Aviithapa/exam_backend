<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Questions\QuestionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\Student\StudentController;
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

Route::get('/', [UserController::class, 'index']);

Route::apiResource('/users', UserController::class);
Route::apiResource('/roles', RoleController::class);
Route::apiResource('/subject', SubjectController::class);
Route::apiResource('/student', StudentController::class);
Route::apiResource('/questions', QuestionsController::class);
Route::post('/importSubject', [SubjectController::class, 'importSubject']);
Route::post('/importQuestions', [QuestionsController::class, 'importQuestions']);
Route::post('/importStudents', [StudentController::class, 'importStudent']);
Route::get('/getStudentBasedOnSubject/{subjectId}', [StudentController::class, 'getStudentBasedOnSubject']);
Route::get('/getQuestionBasedOnSubject/{subjectId}', [QuestionsController::class, 'getQuestionBasedOnSubject']);

// Route::middleware(['auth:api'])->group(
//     function () {
//         Route::apiResource('/questions', QuestionsController::class);
//     }
// );
Route::get('/getRandomQuestion/{subjectId}', [QuestionsController::class, 'getRandomQuestion']);
Route::middleware(['jwt.student.verify'])->group(
    function () {
        Route::apiResource('/attempt', StudentAttemptStudentAttemptController::class);
    }
);

Route::post('/generateToken', [AuthController::class, 'generateToken']);
Route::post('/login', [AuthController::class, 'login']);
