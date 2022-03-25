<?php

namespace Database\Seeders;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserContract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(UserContract::TABLE)->insert([
            MainContract::TOKEN =>  Str::random(30),
            MainContract::POSITION_ID   =>  1,
            MainContract::NAME  => 'User',
            MainContract::SURNAME   =>  'User',
            MainContract::ROLE_ID   =>  1,
            MainContract::EMAIL => 'user@carcity.kz',
            MainContract::EMAIL_VERIFIED_AT =>  now(),
            MainContract::PASSWORD  =>  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            MainContract::REMEMBER_TOKEN    =>  Str::random(10),
        ]);
        DB::table(UserContract::TABLE)->insert([
            MainContract::TOKEN =>  Str::random(30),
            MainContract::POSITION_ID   =>  2,
            MainContract::NAME  => 'Admin',
            MainContract::SURNAME   =>  'Admin',
            MainContract::ROLE_ID   =>  2,
            MainContract::EMAIL => 'admin@carcity.kz',
            MainContract::EMAIL_VERIFIED_AT =>  now(),
            MainContract::PASSWORD  =>  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            MainContract::REMEMBER_TOKEN    =>  Str::random(10),
        ]);
        DB::table(UserContract::TABLE)->insert([
            MainContract::TOKEN =>  Str::random(30),
            MainContract::POSITION_ID   =>  3,
            MainContract::NAME  => 'Manager',
            MainContract::SURNAME   =>  'Manager',
            MainContract::ROLE_ID   =>  3,
            MainContract::EMAIL => 'manager@carcity.kz',
            MainContract::EMAIL_VERIFIED_AT =>  now(),
            MainContract::PASSWORD  =>  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            MainContract::REMEMBER_TOKEN    =>  Str::random(10),
        ]);
        DB::table(UserContract::TABLE)->insert([
            MainContract::TOKEN =>  Str::random(30),
            MainContract::POSITION_ID   =>  4,
            MainContract::NAME  => 'Supervisor',
            MainContract::SURNAME   =>  'Supervisor',
            MainContract::ROLE_ID   =>  4,
            MainContract::EMAIL => 'supervisor@carcity.kz',
            MainContract::EMAIL_VERIFIED_AT =>  now(),
            MainContract::PASSWORD  =>  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            MainContract::REMEMBER_TOKEN    =>  Str::random(10),
        ]);
    }
}
