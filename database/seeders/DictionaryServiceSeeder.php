<?php

namespace Database\Seeders;

use App\Domain\Contracts\DictionaryServiceContract;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DictionaryServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            'Автозвук',
            'Автоэлектрик',
            'Изготовление ключей',
            'Ксенон',
            'ПЗМ',
            'Ремонт генераторов',
            'Ремонт и установка автостекол',
            'Ремонт стартера',
            'Сигнализация',
            'Тонировка',
            'Тюнинг',
            'Шумоизоляция'
        ];

        foreach ($services as $service) {
            DB::table(DictionaryServiceContract::TABLE)->insert([
                DictionaryServiceContract::NAME => $service,
                DictionaryServiceContract::STATUS => 1,
                DictionaryServiceContract::FOR_MENU => 0
            ]);
        }
    }
}
