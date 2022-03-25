<?php

namespace Database\Seeders;

use App\Domain\Contracts\InvoiceStatusContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(InvoiceStatusContract::TABLE)->insert([
            MainContract::TITLE =>  'Новый',
            MainContract::STATUS    =>  1
        ]);
        DB::table(InvoiceStatusContract::TABLE)->insert([
            MainContract::TITLE =>  'Скачано',
            MainContract::STATUS    =>  1
        ]);
    }
}
