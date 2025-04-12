<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $post = Post::inRandomOrder()->first() ?? Post::factory()->create();
        
        return [
            'content' => $this->faker->paragraph(),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            'commentable_id' => $post->id,
            'commentable_type' => Post::class,
        ];
    }
}
