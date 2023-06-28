<?php

namespace Database\Factories;

use http\Client\Curl\User;
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
        $user = \App\Models\User::firstOr(function () {
            return \App\Models\User::factory()->create();
        });
        return [
            'title' => fake()->title,
            'content' => fake()->paragraph(),
            'user_id' => $user,
        ];
    }
}
