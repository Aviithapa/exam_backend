<?php

use App\Http\Controllers\Questions\QuestionsController;
use App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\Student\StudentAttemptController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\StudentAttempt\StudentAttemptController as StudentAttemptStudentAttemptController;
use App\Http\Controllers\Subject\SubjectController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('importSubject', [QuestionsController::class, 'importQuestions']);
Route::apiResource('/questions', QuestionsController::class);
Route::get('/getRandomQuestion/{subjectId}', [QuestionsController::class, 'getRandomQuestion']);
Route::apiResource('/attempt', StudentAttemptStudentAttemptController::class);
