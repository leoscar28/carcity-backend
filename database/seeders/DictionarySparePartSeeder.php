<?php

namespace Database\Seeders;

use App\Domain\Contracts\DictionarySparePartContract;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DictionarySparePartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parts = [
            'Автоинструмент',
            'Автолампы',
            'Автомагнитола',
            'Автосигнализация',
            'Автохимия',
            'АКБ (аккумуляторы)',
            'Аксессуары',
            'Выхлопная система',
            'Генератор и компоненты',
            'Двигатель и элементы двигателя',
            'Детали кузова',
            'Коробка передач/Трансмиссия',
            'Масла/фильтра/спецжидкости',
            'Оборудование для перевозки',
            'Оптика',
            'Патрубки/шланги',
            'Привод/Шрус',
            'Прокладки/сальники',
            'Подшипники',
            'Расходники и комплектующие',
            'Ременный привод',
            'Рулевое управление',
            'Система зажигания',
            'Система отопления и кондиционирования',
            'Система охлаждения',
            'Система подачи воздуха',
            'Система сцепления',
            'Стартер и компоненты',
            'Топливная система',
            'Тормозная система',
            'Турбонагнетатель',
            'Тюнинг',
            'Усиленная подвеска',
            'Ходовая часть',
            'Чехлы/накидки/полики',
            'Шины/диски',
            'Электрика'
        ];

        foreach ($parts as $part) {
            DB::table(DictionarySparePartContract::TABLE)->insert([
                DictionarySparePartContract::NAME => $part,
                DictionarySparePartContract::STATUS => 1,
                DictionarySparePartContract::FOR_MENU => 0
            ]);
        }
    }
}
