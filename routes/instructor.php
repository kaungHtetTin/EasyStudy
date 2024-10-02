<?php

use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\Instructor\
use App\Http\Controllers\Instructor\LayoutController;
use App\Http\Controllers\Instructor\CourseController;
use App\Http\Controllers\Instructor\ModuleController;
use App\Http\Controllers\Instructor\LessonController;
use App\Http\Controllers\Instructor\PaymentMethodController;
use App\Http\Controllers\Instructor\PaymentHistoryController;
use App\Http\Controllers\Instructor\QuestionController;
use App\Http\Controllers\Instructor\ReviewController;

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

        Route::resource('modules',ModuleController::class)->names([
            'index' => 'instructor.modules.lists',
            'create' => 'instructor.module-create',
            'store' => 'instructor.modules.save',
            'show' => 'instructor.modules.view',
            'edit' => 'instructor.modules.modify',
            'update' => 'instructor.modules.change',
            'destroy' => 'instructor.modules.remove',
        ]);

        Route::resource('questions',QuestionController::class)->names([
            'index' => 'instructor.questions.lists',
        ]);

        Route::get('/reviews',[ReviewController::class,'index'])->name('instructor.reviews.lists');
 
        Route::resource('lessons',LessonController::class)->names([
            'store'=>'instructor.lessons.save',
            'destroy'=>'instructor.lessons.remove',
        ]);

        Route::resource('payment-methods',PaymentMethodController::class)->names([
            'index' => 'instructor.payment-methods.lists',
            'store'=>'instructor.payment-methods.save',
            'destroy'=>'instructor.payment-methods.remove',
        ]);

        Route::resource('statements',PaymentHistoryController::class)->names([
            'index'=>'instructor.statements.lists',
            'update'=>'instructor.statements.change',
            'destroy'=>'instructor.statements.remove',
        ]);

        Route::get('/error',[LayoutController::class,'error'])->name('instructor.error');
    });
});
    