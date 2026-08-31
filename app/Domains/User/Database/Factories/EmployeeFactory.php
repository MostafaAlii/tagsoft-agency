<?php

declare(strict_types=1);

namespace Domains\User\Database\Factories;

use Core\Enums\UserStatusEnum;
use Domains\User\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Core\Helpers\UuidHelper;
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'uuid' => UuidHelper::generate(),
            'name'     => $this->faker->name(),
            'email'    => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('123123'),
            'status'   => UserStatusEnum::ACTIVE,
        ];
    }
}