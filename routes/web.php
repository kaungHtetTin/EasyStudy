<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------

| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// main pages
Route::get('/',[LayoutController::class,'index'])->name('index');


// main courses
Route::get('/courses',[CourseController::class,'index'])->name('courses');
Route::get('/courses/{id}',[CourseController::class,'detail'])->name('course_detail');



//instructors
Route::get('/instructors',[InstructorController::class,'index'])->name('instructors');
Route::get('/instructors/{id}',[InstructorController::class,'detail'])->name('instructor_detail');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cart',[CartController::class,'detail'])->name('cart');
    Route::post('/cart',[CartController::class,'create'])->name('cart');
    Route::delete('/cart/{id}',[CartController::class,'destroy'])->name('cart.destroy');

    Route::get('/mycourses',[CourseController::class,'myCourse'])->name('mycourses');

});



require __DIR__.'/auth.php';
