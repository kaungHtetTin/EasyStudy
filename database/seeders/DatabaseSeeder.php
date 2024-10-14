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
use App\Models\SocialMedia;
use App\Models\PaymentMethodType;
use App\Models\Language;

use Illuminate\Support\Str;

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

        Language::create([
            "type"=>"Myanmar",
        ]);

        Language::create([
            "type"=>"English",
        ]);



        Level::create(['level'=>'Beginner']);
        Level::create(['level'=>'Intermediate']);
        Level::create(['level'=>'Expert']);

        User::create([
            'name' => 'Disable User',
            'email' => 'disableemail@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        Instructor::create([
            "user_id"=> 1,
            "student_enroll"=>0,
        ]);

        SocialMedia::create(['media'=>'Facebook','web_icon'=>'<span class="fb"><i class="fab fa-facebook-f"></i></span>']);
        SocialMedia::create(['media'=>'Youtube','web_icon'=>'<span class="yu"><i class="fab fa-youtube"></i></span>']);
        SocialMedia::create(['media'=>'Instagram','web_icon'=>'<span class="ig"><i class="fab fa-instagram"></i></span>']);
        SocialMedia::create(['media'=>'Telegram','web_icon'=>'<span class="tg"><i class="fab fa-telegram"></i></span>']);
        SocialMedia::create(['media'=>'Tikok','web_icon'=>'']);
        SocialMedia::create(['media'=>'Twitter','web_icon'=>'<span class="tw"><i class="fab fa-twitter"></i></span>']);
        SocialMedia::create(['media'=>'LinkIn','web_icon'=>'<span class="ln"><i class="fab fa-linkedin-in"></i></span>']);

        Category::create(['title'=>'Development','web_icon'=>"<i class='uil uil-arrow'></i>"]);
        Category::create(['title'=>'Business','web_icon'=>"<i class='uil uil-graph-bar'></i>"]);
        Category::create(['title'=>'Finance & Accounting','web_icon'=>"<i class='uil uil-calcualtor'></i>"]);
        Category::create(['title'=>'IT & Software','web_icon'=>"<i class='uil uil-monitor'></i>"]);
        Category::create(['title'=>'Office Productivity','web_icon'=>""]);
        Category::create(['title'=>'Personal Development','web_icon'=>"<i class='uil uil-book-open'></i>"]);
        Category::create(['title'=>'Design','web_icon'=>"<i class='uil uil-ruler'></i>"]);
        Category::create(['title'=>'Marketing','web_icon'=>"<i class='uil uil-chart-line'></i>"]);
        Category::create(['title'=>'Lifestyle','web_icon'=>""]);
        Category::create(['title'=>'Photography & video','web_icon'=>"<i class='uil uil-camera'></i>"]);
        Category::create(['title'=>'Health & Fitness','web_icon'=>""]);
        Category::create(['title'=>'Music','web_icon'=>"<i class='uil uil-music'></i>"]);


        User::create([
            'name' => 'Disable User',
            'email' => 'disable@calamus.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Super Admin',
            'email' => 'super@calamus.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);


        User::factory(100)->create();
        $instructors = Instructor::factory()
            ->count(10)
            ->create();
       
        SubCategory::factory(30)->create();
        Topic::factory(120)->create();

        Course::factory(50)->create();
        Module::factory(500)->create();
        Lesson::factory(3000)->create();
        Review::factory(100)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
