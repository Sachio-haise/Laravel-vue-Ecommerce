<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NovelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->company();
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'author' => $this->faker->name(),
        ];
    }
}
