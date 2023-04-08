<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Questions\QuestionsController;
use App\Http\Controllers\StudentAttempt\StudentAttemptController as StudentAttemptStudentAttemptController;
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
Route::middleware(['auth:api'])->group(
    function () {
        Route::apiResource('/questions', QuestionsController::class);
    }
);
Route::get('/getRandomQuestion/{subjectId}', [QuestionsController::class, 'getRandomQuestion']);
Route::apiResource('/attempt', StudentAttemptStudentAttemptController::class);
Route::post('/login', [AuthController::class, 'login']);
