<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\InstructorController;
use App\Http\Controllers\Api\LearningHistoryController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ConversationController;
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

    Route::post('/courses',[CourseController::class,'store']);

    Route::apiResource('answers', AnswerController::class);
    Route::apiResource('questions', QuestionController::class);
  
    Route::apiResource('announcements', AnnouncementController::class);
    Route::get('messages/refresh',[MessageController::class,'refresh']);
    Route::apiResource('messages', MessageController::class);
    Route::apiResource('chatrooms', ConversationController::class);
    Route::apiResource('notifications', NotificationController::class);
    Route::post('/mark-as-read-all-notifications',[NotificationController::class,'markAsReadAll']);
 
});




Route::get('/courses',[CourseController::class,'index']);
Route::get('/courses/search',[CourseController::class,'search']);
Route::post('/courses/pre-view/{id}',[CourseController::class,'playPreView']);
Route::post('/courses/share/{id}',[CourseController::class,'share']);
Route::get('/courses/{id}/reviews',[CourseController::class,'reviews']);
Route::get('/courses/{id}/lessons',[CourseController::class,'lessons']);
Route::get('/courses/{id}/questions',[CourseController::class,'questions']);
Route::get('/courses/{id}/questions/search',[CourseController::class,'searchQuestion']);
Route::get('/courses/{id}/announcements',[CourseController::class,'announcements']);
Route::get('/courses/{id}/questions/{qid}/answers',[CourseController::class,'answers']);

Route::get('/instructors',[InstructorController::class,'index']);
Route::get('/instructors/search',[InstructorController::class,'search']);
Route::get('/instructors/{id}/blogs',[InstructorController::class,'blogs']);

Route::post('/questions/upload-photo',[QuestionController::class,'uploadPhoto']);

Route::post('/blogs/upload-photo',[BlogController::class,'uploadPhoto']);

Route::get('/answers',[AnswerController::class,'index']);
