<?php

namespace Database\Factories;

use App\Models\Novel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ChapterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->title();
        return [
            'novel_id' => Novel::all()->random()->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'paragraph' => $this->faker->realText(1000),
        ];
    }
}
