<?php

namespace Database\Seeders;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\PositionContract;
use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(PositionContract::TABLE)->insert([
            MainContract::TITLE =>  'Пользователь',
            MainContract::STATUS    =>  1
        ]);
        DB::table(PositionContract::TABLE)->insert([
            MainContract::TITLE =>  'Администратор',
            MainContract::STATUS    =>  1
        ]);
        DB::table(PositionContract::TABLE)->insert([
            MainContract::TITLE =>  'Менеджер',
            MainContract::STATUS    =>  1
        ]);
        DB::table(PositionContract::TABLE)->insert([
            MainContract::TITLE =>  'Руководитель',
            MainContract::STATUS    =>  1
        ]);
    }
}
