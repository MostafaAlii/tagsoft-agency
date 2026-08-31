<?php

declare(strict_types=1);

namespace Domains\User\Database\Seeders;

use Domains\User\Models\{Admin,Client,Employee};
use Illuminate\Database\Seeder;

class UserDomainSeeder extends Seeder
{
    public function run(): void
    {
        Admin::factory()
            ->count(3)
            ->create()
            ->each(fn(Admin $admin) => $admin->profile()->update([
                'phone'     => fake()->phoneNumber(),
                'job_title' => fake()->jobTitle(),
            ]));

        Client::factory()
            ->count(10)
            ->create()
            ->each(fn(Client $client) => $client->profile()->update([
                'address'    => fake()->address(),
                'city'       => fake()->city(),
                'birth_date' => fake()->date(),
            ]));

        Employee::factory()
            ->count(5)
            ->create()
            ->each(fn(Employee $employee) => $employee->profile()->update([
                'department' => fake()->randomElement(['Sales', 'IT', 'HR']),
                'position'   => fake()->jobTitle(),
                'hired_at'   => fake()->date(),
            ]));
    }
}