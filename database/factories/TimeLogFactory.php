<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\TimeLog;

class TimeLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TimeLog::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid,
            'employee_id' => Employee::factory(),
//            'started_at' => $this->faker->dateTime(),
//            'stopped_at' => $this->faker->dateTime(),
            'started_at' => now(),
            'stopped_at' => now(),
            'minutes' => $this->faker->randomNumber(),
        ];
    }
}
