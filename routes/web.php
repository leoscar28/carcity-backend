<?php

use App\Domain\Contracts\MainContract;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {/*
    $list   =    DB::table('table_name')->get();
    $emails =   [];
    $phones =   [];
    $aliases    =   [];
    foreach ($list as &$value) {
        if (trim($value->{'column_7'}) !== '' && ((trim($value->{'column_6'}) !== '' && $value->{'column_6'} !== null) || (trim($value->{'Email'}) !== '' && $value->{'Email'} !== null) || (trim($value->{'_'}) !== '' && $value->{'_'} !== null))) {
            $al =   trim($value->{'column_6'});
            $em =   strtolower(trim($value->{'Email'}));
            User::create([
                MainContract::REMEMBER_TOKEN    =>  Str::random(10),
                MainContract::TOKEN =>  Str::random(40),
                MainContract::ALIAS =>  in_array($al,$aliases)?null:$al,
                MainContract::NAME  =>  $value->{MainContract::NAME},
                MainContract::SURNAME   =>  $value->{MainContract::NAME},
                MainContract::POSITION_ID   =>  1,
                MainContract::ROLE_ID   =>  1,
                MainContract::EMAIL =>  in_array($em,$emails)?null:$em,
                MainContract::EMAIL_VERIFIED_AT =>  in_array($em,$emails)?null:now(),
                MainContract::PASSWORD  =>  $value->{'column_7'},
                MainContract::BIN   =>  $value->{'column_2'},
                MainContract::COMPANY   =>  $value->{'fullname'},
                MainContract::PHONE =>  in_array($value->{'_'},$phones)?null:$value->{'_'},
                MainContract::PHONE_VERIFIED_AT =>  in_array($value->{'_'},$phones)?null:now(),
            ]);
            print_r([
                MainContract::REMEMBER_TOKEN    =>  Str::random(10),
                MainContract::TOKEN =>  Str::random(40),
                MainContract::ALIAS =>  in_array($value->{'column_6'},$aliases)?null:$value->{'column_6'},
                MainContract::NAME  =>  $value->{MainContract::NAME},
                MainContract::SURNAME   =>  $value->{MainContract::NAME},
                MainContract::POSITION_ID   =>  1,
                MainContract::ROLE_ID   =>  1,
                MainContract::EMAIL =>  in_array($value->{'Email'},$emails)?null:$value->{'Email'},
                MainContract::EMAIL_VERIFIED_AT =>  in_array($value->{'Email'},$emails)?null:now(),
                MainContract::PASSWORD  =>  $value->{'column_7'},
                MainContract::BIN   =>  $value->{'column_2'},
                MainContract::COMPANY   =>  $value->{'fullname'},
                MainContract::PHONE =>  in_array($value->{'_'},$phones)?null:$value->{'_'},
                MainContract::PHONE_VERIFIED_AT =>  in_array($value->{'_'},$phones)?null:now(),
            ]);
            $emails[]   =   $em;
            $phones[]   =   $value->{'_'};
            $aliases[]  =   $al!==''?$al:null;
            echo '<br><br>';
            echo $value->{'Email'}.'==='.$value->{'_'};
            echo '<br><br><br>';
        }
    }
    return;*/
    return view('welcome');
});
