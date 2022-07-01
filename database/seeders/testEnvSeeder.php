<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Novel;
use Illuminate\Database\Seeder;

class testEnvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(1)->create();
        Role::factory()->count(1)->create();
        Category::factory()->count(10)->create();
        Novel::factory()->count(10)->create();
        Chapter::factory()->count(50)->create();

        $categories = Category::all();
        Novel::all()->each(function ($novel) use ($categories) {
            $novel->categories()->attach(
                $categories->random(2)->pluck('id')->toArray()
            );
        });
    }
}
