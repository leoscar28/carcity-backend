<?php

namespace Database\Factories;

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompletionFactory extends Factory
{
    public function definition():array
    {
        return [
            MainContract::UPLOAD_STATUS_ID  =>  1,
            MainContract::CUSTOMER  =>  $this->faker->sentence,
            MainContract::CUSTOMER_ID   =>  rand(1000000,9999999),
            MainContract::NUMBER    =>  $this->faker->sentence,
            MainContract::ORGANIZATION  =>  $this->faker->sentence,
            MainContract::DATE  =>  date('Y-m-d'),
            MainContract::SUM   =>  $this->faker->sentence,
            MainContract::NAME  =>  $this->faker->sentence,
            MainContract::STATUS    =>  1,
        ];
    }
}
