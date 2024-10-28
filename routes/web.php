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
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;

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

// secondary pages
Route::get('/about-us',[LayoutController::class,'aboutPage'])->name('about-us');
Route::get('/press',[LayoutController::class,'pressPage'])->name('press');
Route::get('/contact-us',[LayoutController::class,'contactPage'])->name('contact-us');
Route::get('/get-mobile-app',[LayoutController::class,'getAppPage'])->name('get-mobile-app');
Route::get('/help',[LayoutController::class,'helpPage'])->name('help');
Route::get('/privacy-policy',[LayoutController::class,'privacyPolicyPage'])->name('privacy-policy');
Route::get('/terms',[LayoutController::class,'termPage'])->name('terms');
Route::get('/teach-on',[LayoutController::class,'teachOnPage'])->name('teach-on');
Route::get('/sitemap',[LayoutController::class,'siteMapPage'])->name('sitemap');
Route::get('/error',function(){  return view('student.error',['page_title'=>'Error']); })->name('error');
Route::get('/explore',function(){  return view('student.explore',['page_title'=>'Explore']); })->name('explore');

Route::get('/blogs',[BlogController::class,'index'])->name('blogs.lists');

// main courses
Route::get('/courses',[CourseController::class,'index'])->name('courses');
Route::get('/courses/{id}',[CourseController::class,'detail'])->name('course_detail');

//instructors
Route::get('/instructors',[InstructorController::class,'index'])->name('instructors');
Route::get('/instructors/{id}',[InstructorController::class,'detail'])->name('instructor_detail');
Route::get('/instructors/{id}/blogs/{bid}',[InstructorController::class,'showBlog'])->name('instructor.blog.view');

Route::get('/editor',function(){
    return view('editor');
});



Route::post('/editor',[CourseController::class,'update']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/users/{id}', [ProfileController::class, 'index'])->name('profile');

Route::middleware('auth')->group(function () {
    
    //user profile
    
    Route::get('/setting', [ProfileController::class, 'edit'])->name('setting');
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

    Route::post('/instructors/{id}/subscribe',[InstructorController::class,'subscribe'])->name('instructor.subscribe');

    Route::post('/questions',[QuestionController::class,'create'])->name('question.create');

    Route::get('/notifications',[NotificationController::class,'index'])->name('notifications.list');
   
    Route::get('/feedback/create',[FeedbackController::class,'create'])->name('feedback.create');
    Route::post('/feedback',[FeedbackController::class,'store'])->name('feedback.save');

    Route::get('/reports',[ReportController::class,'index'])->name('reports.list');

    Route::get('/chatrooms',[ConversationController::class,'index'])->name('chatrooms.lists');
    Route::get('/chatrooms/{id}',[ConversationController::class,'show'])->name('chatrooms.view');
    Route::delete('/chatrooms',[ConversationController::class,'destroy'])->name('chatrooms.remove');

    Route::get('users/{id}/message',[UserController::class,'message'])->name('users.message');
    Route::post('users/{id}/block',[UserController::class,'block'])->name('users.block');
    Route::post('users/{id}/unblock',[UserController::class,'unblock'])->name('users.unblock');
    
    Route::get('/subscriptions',[LayoutController::class,'subscription'])->name('subscriptions');
});



require __DIR__.'/auth.php';
