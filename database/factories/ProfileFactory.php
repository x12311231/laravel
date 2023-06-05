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
            'site' => $this->faker->regexify('[A-Za-z0-9]{400}'),
            'belief' => $this->faker->text,
            'age' => $this->faker->numberBetween(-10000, 10000),
            'phone' => $this->faker->phoneNumber,
            'wechat' => $this->faker->word,
//            'deleted_at' => $this->faker->dateTime(),
            'user_id' => User::factory(),
        ];
    }
}
