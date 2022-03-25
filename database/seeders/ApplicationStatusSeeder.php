<?php

namespace Database\Seeders;

use App\Domain\Contracts\ApplicationStatusContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(ApplicationStatusContract::TABLE)->insert([
            MainContract::TITLE =>  'Ожидает подписания вами',
            MainContract::STATUS    =>  1
        ]);
        DB::table(ApplicationStatusContract::TABLE)->insert([
            MainContract::TITLE =>  'Ожидает подписания клиентом',
            MainContract::STATUS    =>  1
        ]);
        DB::table(ApplicationStatusContract::TABLE)->insert([
            MainContract::TITLE =>  'Подписано клиентами',
            MainContract::STATUS    =>  1
        ]);
    }
}
