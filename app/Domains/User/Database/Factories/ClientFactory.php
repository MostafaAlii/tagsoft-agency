<?php

declare(strict_types=1);

namespace Domains\User\Database\Factories;

use Core\Enums\UserStatusEnum;
use Domains\User\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Core\Helpers\UuidHelper;
class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'uuid' => UuidHelper::generate(),
            'name'     => $this->faker->name(),
            'email'    => $this->faker->unique()->safeEmail(),
            'phone'    => $this->faker->phoneNumber(),
            'password' => Hash::make('123123'),
            'status'   => UserStatusEnum::ACTIVE,
        ];
    }
}