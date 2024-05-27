<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "course_id"=>rand(1,50),
            "module_id"=>rand(1,500),
            "lesson_type_id"=>rand(1,3),
            "title"=>ucwords($this->faker->word),
            "duration"=>rand(180,600)

        ];
    }
}
