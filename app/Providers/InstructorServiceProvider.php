<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use App\Models\Instructor;
use App\Models\PaymentHistory;

class InstructorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $excludedViews = [
            'student.*',
            'pages.*',
            'instructor.components.*',
            'instructor.master'
            // Add other views you want to exclude
        ];

        // Using closure based composers...
       View::composer('*', function ($view) use ($excludedViews) {
            foreach ($excludedViews as $pattern) {
                if (Str::is($pattern, $view->getName())) {
                    return;
                }
            }
    
            $user = Auth::user();
            if($user==null){
                return $view->with('instructor', false);
            }
            $instructor = Instructor::where('user_id',$user->id)->first();
            $unapproved_payment_count = PaymentHistory::where('instructor_id',$instructor->id)->where('verified',0)->count();

            $view->with([
                'unapproved_payment_count'=>$unapproved_payment_count,
            ]);
        });
    }
}
