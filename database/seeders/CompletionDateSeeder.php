<?php

namespace Database\Seeders;

use App\Models\CompletionDate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompletionDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompletionDate::factory(300)->create();
    }
}
