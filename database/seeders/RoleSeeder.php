<?php

namespace Database\Seeders;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\RoleContract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(RoleContract::TABLE)->insert([
            MainContract::TITLE =>  'Пользователь',
            MainContract::STATUS    =>  1
        ]);
        DB::table(RoleContract::TABLE)->insert([
            MainContract::TITLE =>  'Администратор',
            MainContract::STATUS    =>  1
        ]);
        DB::table(RoleContract::TABLE)->insert([
            MainContract::TITLE =>  'Менеджер',
            MainContract::STATUS    =>  1
        ]);
        DB::table(RoleContract::TABLE)->insert([
            MainContract::TITLE =>  'Руководитель',
            MainContract::STATUS    =>  1
        ]);
        DB::table(RoleContract::TABLE)->insert([
            MainContract::TITLE =>  'Арендатор',
            MainContract::STATUS    =>  1
        ]);
    }
}
