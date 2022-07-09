<?php

namespace App\Providers\Repositories;

use Illuminate\Support\ServiceProvider;

class InstructionRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Domain\Repositories\Instruction\InstructionRepositoryInterface::class,
            \App\Domain\Repositories\Instruction\InstructionRepositoryEloquent::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
