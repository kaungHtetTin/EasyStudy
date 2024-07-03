<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\InstructorController;
use App\Http\Controllers\Api\LearningHistoryController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function(Request $req){return $req->user();});
    Route::get('/courses',[CourseController::class,'index']);
    Route::post('/courses/react/{id}',[CourseController::class,'react']);

    Route::post('/learning-histories',[LearningHistoryController::class,'create']);
});

Route::post('/courses/pre-view/{id}',[CourseController::class,'playPreView']);
Route::post('/courses/share/{id}',[CourseController::class,'share']);
Route::get('/courses/{id}/reviews',[CourseController::class,'reviews']);
Route::get('/courses/{id}/lessons',[CourseController::class,'lessons']);
Route::get('/courses/{id}/questions',[CourseController::class,'questions']);
Route::get('/courses/{id}/questions/{qid}/answers',[CourseController::class,'answers']);

Route::get('/instructors',[InstructorController::class,'index']);
