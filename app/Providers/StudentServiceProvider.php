<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Instructor;
use App\Models\Notification;
use App\Models\Conversation;
use App\Models\Subscriber;

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
                $unseen_notification_count =0;
                $unseen_message_count = 0;
                $subscriptions = false;
            }else{
                $instructor = Instructor::where('user_id',$user->id)->first();
                $unseen_notification_count = Notification::where('passive_user_id',$user->id)
                ->where('seen',0)
                ->where('passive_user_type',3)
                ->count();
                $unseen_message_count = Conversation::where('my_id',$user->id)->where('seen',0)->count();
                $user->refresh_count = $user->refresh_count + 1;
                $user->save();
                $subscriptions = Subscriber::where('user_id',$user->id)->orderBy('updated_at','desc')->limit(5)->get();
            }

            $view->with([
                'categories'=>$categories,
                'is_current_user_instructor'=>$instructor,
                'unseen_notification_count'=>$unseen_notification_count,
                'unseen_message_count'=>$unseen_message_count,
                'subscriptions'=>$subscriptions,
            ]);

            
        });
    }
}
