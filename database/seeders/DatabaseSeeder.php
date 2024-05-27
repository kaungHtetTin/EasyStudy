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
        User::factory(100)->create();
        $instructors = Instructor::factory()
            ->count(10)
            ->create();
        $categories=Category::factory(10)->create();
        Course::factory(50)->create();
        Module::factory(500)->create();
        Lesson::factory(3000)->create();

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
