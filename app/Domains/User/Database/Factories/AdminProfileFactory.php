<?php

declare(strict_types=1);

namespace Domains\User\Database\Factories;

use Domains\User\Models\Admin;
use Domains\User\Models\AdminProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminProfileFactory extends Factory
{
    protected $model = AdminProfile::class;

    public function definition(): array
    {
        return [
            'admin_id'  => Admin::factory(),
            'phone'     => $this->faker->phoneNumber(),
            'job_title' => $this->faker->jobTitle(),
        ];
    }
}