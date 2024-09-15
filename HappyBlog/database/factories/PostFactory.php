<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->title();
        return [
            'title' => $title,
            'content' => fake()->text(),
            'author' =>User::inRandomOrder()->first()->id ?? User::factory(),
            'slug' => str_replace(' ','_',strtolower($title)),
        ];
    }
}
