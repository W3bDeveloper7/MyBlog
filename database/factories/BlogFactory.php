<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->realText(50),
            'blog_content' => $this->faker->paragraph(15),
            'published_at' => now(),
            'image' => $this->faker->imageUrl(640, 480, 'sports', true, 'football'),
            'user_id'   => 1,
        ];
    }
}
