<?php

declare(strict_types=1);

namespace Domains\User\Database\Factories;

use Domains\User\Models\Employee;
use Domains\User\Models\EmployeeProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeProfileFactory extends Factory
{
    protected $model = EmployeeProfile::class;

    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'department'  => $this->faker->randomElement(['Sales', 'IT', 'HR', 'Finance']),
            'position'    => $this->faker->jobTitle(),
            'hired_at'    => $this->faker->date(),
        ];
    }
}