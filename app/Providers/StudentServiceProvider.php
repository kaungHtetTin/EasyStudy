<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Instructor;
use Illuminate\Support\Str;

class StudentServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $excludedViews = [
            'student.components.*',
            'instructor.*'
            // Add other views you want to exclude
        ];

        // Using closure based composers...
       View::composer('*', function ($view) use ($excludedViews) {
            foreach ($excludedViews as $pattern) {
                if (Str::is($pattern, $view->getName())) {
                    return;
                }
            }

            $categories = Category::all();

            $user = Auth::user();
            if($user==null){
                $instructor = false;
            }else{
                $instructor = Instructor::where('user_id',$user->id)->first();
            }
            
            $view->with([
                'categories'=>$categories,
                'is_current_user_instructor'=>$instructor,
            ]);

            
        });
    }
}
