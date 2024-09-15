<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $has_parent = rand(1,3) >=2;
        return [
            'title' => fake()->title(),
            'parent_id' => $has_parent?Category::inRandomOrder()->first()->id ?? Category::factory():null
        ];
    }
}
