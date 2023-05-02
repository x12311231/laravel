<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Image;
use App\Models\User;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'path' => $this->faker->regexify('[A-Za-z0-9]{400}'),
            'url' => $this->faker->url,
            'author_id' => User::factory(),
        ];
    }
}
