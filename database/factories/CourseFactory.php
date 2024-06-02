<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Topic;
use App\Models\Instructor;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "instructor_id"=>Instructor::factory(),
            "category_id"=>rand(1,5),
            "sub_category_id"=>rand(1,30),
            "topic_id"=>rand(1,120),
            "title"=>ucwords($this->faker->word),
            "description"=>ucwords($this->faker->paragraph),
            "duration"=>rand(300,3000),
            "visit"=>rand(10,10000),
            "rating"=>rand(1,5),
            "fee"=>rand(10000,100000),
            "certificate"=>rand(0,1),
        ];
    }
}
