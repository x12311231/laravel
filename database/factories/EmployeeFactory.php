<?php

namespace Database\Factories;

use App\Enum\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Department;
use App\Models\Employee;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid,
            'full_name' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'email' => $this->faker->safeEmail,
            'department_id' => Department::factory(),
            'job_title' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'payment_type' => random_int(0, 1) === 0 ? Payment::SALARY->value : Payment::HOURLY_RATE->value,
            'salary' => $this->faker->randomNumber(),
            'hourly_rate' => $this->faker->randomNumber(),
        ];
    }
}
