<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
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

    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(3, true),
            'is_published' => false,
            'user_id' => User::factory(),
        ];
    }

    public function published(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_published' => true,
            ];
        });
    }
}
