<?php

use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\NotificationController;

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
Route::get('/explore',[LayoutController::class,'explore'])->name('explore');

// secondary pages
Route::get('/about-us',[LayoutController::class,'aboutPage'])->name('about-us');
//Route::get('/blog',[LayoutController::class,'aboutPage'])->name('about-us');
Route::get('/contact-us',[LayoutController::class,'contactPage'])->name('contact-us');
Route::get('/get-mobile-app',[LayoutController::class,'getAppPage'])->name('get-mobile-app');
Route::get('/help',[LayoutController::class,'helpPage'])->name('help');
Route::get('/privacy-policy',[LayoutController::class,'privacyPolicyPage'])->name('privacy-policy');
Route::get('/terms',[LayoutController::class,'termPage'])->name('terms');
Route::get('/teach-on',[LayoutController::class,'teachOnPage'])->name('teach-on');
Route::get('/sitemap',[LayoutController::class,'siteMapPage'])->name('sitemap');
Route::get('/error',function(){  return view('student.error',['page_title'=>'Error']); })->name('error');


// main courses
Route::get('/courses',[CourseController::class,'index'])->name('courses');
Route::get('/courses/{id}',[CourseController::class,'detail'])->name('course_detail');



//instructors
Route::get('/instructors',[InstructorController::class,'index'])->name('instructors');
Route::get('/instructors/{id}',[InstructorController::class,'detail'])->name('instructor_detail');

Route::get('/editor',function(){
    return view('editor');
});



Route::post('/editor',[CourseController::class,'update']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    //user profile
    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update',[ProfileController::class,'updateProfile'])->name('profile.update');
    Route::post('/profile/update-image',[ProfileController::class,'updateImage'])->name('profile.updateImage');

    Route::patch('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/cart',[CartController::class,'detail'])->name('cart');
    Route::post('/cart',[CartController::class,'create'])->name('cart');
    Route::delete('/cart/{id}',[CartController::class,'destroy'])->name('cart.destroy');

    Route::get('/mycourses',[CourseController::class,'myCourse'])->name('mycourses');
    Route::post('/courses/checkout/{id}',[CourseController::class,'checkOut'])->name('course.checkout');
    Route::get('/courses/{id}/learn',[CourseController::class,'learn'])->name('course.learn');

    Route::post('/reviews',[ReviewController::class,'create'])->name('reviews.create');
    Route::delete('/reviews/{id}',[ReviewController::class,'destroy'])->name('reviews.destroy');
    Route::post('/reviews/update',[ReviewController::class,'update'])->name('reviews.update');

    Route::post('/instructors/subscribe/{id}',[InstructorController::class,'subscribe'])->name('instructor.subscribe');

    Route::post('/questions',[QuestionController::class,'create'])->name('question.create');

    Route::get('/notifications',[NotificationController::class,'index'])->name('notifications.list');
   
});



require __DIR__.'/auth.php';
