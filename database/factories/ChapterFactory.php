<?php

namespace Database\Factories;

use App\Models\Novel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChapterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'novel_id' => Novel::all()->random()->id,
            'title' => $this->faker->title(),
            'paragraph' => $this->faker->realText(1000),
        ];
    }
}
