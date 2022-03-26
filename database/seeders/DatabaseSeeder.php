<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Completion;
use App\Models\Invoice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        //User::factory()->create();

        //Application::factory(1000)->create();
        //Invoice::factory(1000)->create();
        //Completion::factory(1000)->create();
        $this->call(RoleSeeder::class);
        //$this->call(UserSeeder::class);
        $this->call(CompletionStatusSeeder::class);
        $this->call(ApplicationStatusSeeder::class);
        $this->call(InvoiceStatusSeeder::class);
    }
}
