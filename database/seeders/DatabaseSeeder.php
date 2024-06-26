<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\LessonType;
use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\Instructor;
use App\Models\SubCategory;
use App\Models\Topic;
use App\Models\Level;
use App\Models\Review;
use App\Models\PaymentMethodType;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        LessonType::create([
            "type"=>"Video"
        ]);
        LessonType::create([
            "type"=>"Document"
        ]);
        LessonType::create([
            "type"=>"Test"
        ]);

        PaymentMethodType::create([
            "type"=>"Kbz Pay",
            "icon_url"=>"images/payment-kbz-pay.jpg",
        ]);
        PaymentMethodType::create([
            "type"=>"Wave Pay",
            "icon_url"=>"images/payment-wave-pay.jpg",
        ]);
        PaymentMethodType::create([
            "type"=>"AYA pay",
            "icon_url"=>"images/payment-aya-pay.png",
        ]);
        PaymentMethodType::create([
            "type"=>"CB pay",
            "icon_url"=>"images/payment-cb-pay.png",
        ]);


        Level::create(['level'=>'Beginner']);
        Level::create(['level'=>'Intermediate']);
        Level::create(['level'=>'Expert']);

        User::factory(100)->create();
        $instructors = Instructor::factory()
            ->count(10)
            ->create();
        $categories=Category::factory(5)->create();
        SubCategory::factory(30)->create();
        Topic::factory(120)->create();

        Course::factory(50)->create();
        Module::factory(500)->create();
        Lesson::factory(3000)->create();
        Review::factory(100)->create();

        $instructors->each(function ($instructor) use ($categories) {
            $instructor->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
       

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
