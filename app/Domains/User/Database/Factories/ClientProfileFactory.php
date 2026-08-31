<?php

declare(strict_types=1);

namespace Domains\User\Database\Factories;

use Domains\User\Models\Client;
use Domains\User\Models\ClientProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientProfileFactory extends Factory
{
    protected $model = ClientProfile::class;

    public function definition(): array
    {
        return [
            'client_id'  => Client::factory(),
            'address'    => $this->faker->address(),
            'city'       => $this->faker->city(),
            'birth_date' => $this->faker->date(),
        ];
    }
}