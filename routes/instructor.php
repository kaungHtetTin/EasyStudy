<?php

use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\Instructor\
use App\Http\Controllers\Instructor\LayoutController;
use App\Http\Controllers\Instructor\CourseController;

Route::middleware('auth')->group(function () {
    Route::middleware('instructor')->group(function (){
        Route::get('/',[LayoutController::class,'index'])->name('instructor.home');
        // Route::get('/course/create',[LayoutController::class,'courseCreate'])->name('instructor.course-create');

        Route::resource('courses',CourseController::class)->names([
            'index' => 'instructor.courses.lists',
            'create' => 'instructor.course-create',
            'store' => 'instructor.courses.save',
            'show' => 'instructor.courses.view',
            'edit' => 'instructor.courses.modify',
            'update' => 'instructor.courses.change',
            'destroy' => 'instructor.courses.remove',
        ]);

    });
});
    