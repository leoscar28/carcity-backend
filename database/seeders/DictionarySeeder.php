<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Completion;
use App\Models\Invoice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DictionarySeeder extends Seeder
{
    public function run()
    {
        $this->call(DictionarySparePartSeeder::class);
        $this->call(DictionaryServiceSeeder::class);
        $this->call(DictionaryBrandSeeder::class);
    }
}
