<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
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
        $title = implode(" ",fake()->words(3));
        return [
            'title' => ucfirst($title),
            'content' => fake()->text(),
            'author' =>User::inRandomOrder()->first()->id ?? User::factory(),
            'slug' => str_replace(' ','_',strtolower($title)),
        ];
    }

   public function configure()
   {
    return $this->afterCreating(function (Post $post){
        $cats = Category::all()->random(rand(1, 3))->pluck('id');
        $post->categories()->attach($cats);
        $tags = Tag::all()->random(rand(1,3))->pluck('id');
        $post->tags()->attach($tags);
    });
   }
}
