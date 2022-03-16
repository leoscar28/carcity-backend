<?php

namespace Database\Seeders;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UploadStatusContract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UploadStatusSeeder extends Seeder
{
    public function run()
    {
        DB::table(UploadStatusContract::TABLE)->insert([
            MainContract::TITLE =>  'Ожидает подписания вами',
            MainContract::STATUS    =>  1
        ]);
        DB::table(UploadStatusContract::TABLE)->insert([
            MainContract::TITLE =>  'Ожидает подписания клиентом',
            MainContract::STATUS    =>  1
        ]);
        DB::table(UploadStatusContract::TABLE)->insert([
            MainContract::TITLE =>  'Подписано клиентами',
            MainContract::STATUS    =>  1
        ]);
    }
}
