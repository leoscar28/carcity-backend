<?php

namespace Database\Factories;

use App\Domain\Contracts\MainContract;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompletionDate>
 */
class CompletionDateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition():array
    {
        return [
            MainContract::UPLOAD_STATUS_ID  =>  1,
            MainContract::RID   =>  rand(3,100),
            MainContract::DOCUMENT_ALL  =>  0,
            MainContract::DOCUMENT_AVAILABLE    =>  0,
            MainContract::COMMENT   =>  NULL,
            MainContract::STATUS    =>  1
        ];
    }
}
