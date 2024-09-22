<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Models\User;

use App\Http\Controllers\Api\Instructor\CourseController;
use App\Http\Controllers\Api\Instructor\ModuleController;
use App\Http\Controllers\Api\Instructor\LessonController;

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

    //Route::get('/draft-courses',[DraftCourseController::class,'index']);
    Route::apiResource('courses', CourseController::class);
    Route::post('/courses/{id}/update-cover-image',[CourseController::class,'changeCoverImage']);

    Route::apiResource('modules', ModuleController::class);
    Route::apiResource('lessons', LessonController::class);
 
});
