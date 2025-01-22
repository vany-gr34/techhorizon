<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            
                'title' => $this->faker->sentence(), // Random title
                'content' => $this->faker->paragraph(5), // Random content
                'image' => 'images/' . $this->faker->image('public/storage/images', 640, 480, null, false), // Random image
            
        ];
    }
}
