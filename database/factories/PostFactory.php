<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use Illuminate\Support\Str;

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
        $imagePath = 'images/example_image.png';
        $imageName = basename($imagePath);
        $content = $this->faker->paragraphs(5, true);
        while (Str::length($content) < 1000) {
            $content .= $this->faker->paragraph();
        }

        return [
            'title' => $this->faker->sentence(),
            'content' => $content,
            'category_id' => Category::all()->random()->id,
            'author' => $this->faker->name,
            'image' => $imageName,
        ];
    }
}
