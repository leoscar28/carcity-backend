<?php

namespace Database\Factories;

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{

    public function definition(): array
    {
        return [
            MainContract::TOKEN =>  $this->faker->sentence,
            MainContract::NAME  => 'Admin',
            MainContract::SURNAME   =>  'Admin',
            MainContract::ROLE_ID   =>  2,
            MainContract::EMAIL => 'admin@carcity.kz',
            MainContract::EMAIL_VERIFIED_AT =>  now(),
            MainContract::PASSWORD  =>  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            MainContract::REMEMBER_TOKEN    =>  Str::random(10),
        ];
    }

    public function unverified(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
