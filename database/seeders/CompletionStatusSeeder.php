<?php

namespace Database\Seeders;

use App\Domain\Contracts\CompletionStatusContract;
use App\Domain\Contracts\MainContract;
use App\Models\CompletionStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompletionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(CompletionStatusContract::TABLE)->insert([
            MainContract::TITLE =>  'Новый',
            MainContract::STATUS    =>  1
        ]);
        DB::table(CompletionStatusContract::TABLE)->insert([
            MainContract::TITLE =>  'Скачано',
            MainContract::STATUS    =>  1
        ]);
    }
}
