<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Profile;
use App\Models\User;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'webSite' => $this->faker->regexify('[A-Za-z0-9]{400}'),
            'sex' => $this->faker->randomElement(/** enum_attributes **/),
            'user_id' => User::factory(),
        ];
    }
}
