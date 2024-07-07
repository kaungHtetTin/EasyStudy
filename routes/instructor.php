<?php

use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\Instructor\
use App\Http\Controllers\Instructor\LayoutController;

Route::middleware('auth')->group(function () {

    Route::middleware('instructor')->group(function (){
        Route::get('/',[LayoutController::class,'index'])->name('instructor.home');
        Route::get('/course/create',[LayoutController::class,'courseCreate'])->name('instructor.course-create');
    });
});
    