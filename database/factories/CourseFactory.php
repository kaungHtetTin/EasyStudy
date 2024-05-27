<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            "category_id"=>rand(1,10),
            "instructor_id"=>rand(1,10),
            "title"=>ucwords($this->faker->word),
            "description"=>ucwords($this->faker->paragraph),
            "duration"=>rand(300,3000),
            "visit"=>rand(10,10000),
            "rating"=>rand(1,5),
            "fee"=>rand(10000,100000),
            
            

        ];
    }
}
