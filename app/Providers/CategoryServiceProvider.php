<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryServiceProvider extends ServiceProvider
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
            'layouts.*',
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
            $view->with('categories', $categories);
        });
    }
}
