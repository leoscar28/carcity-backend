<?php

namespace App\Domain\Repositories\User;

use App\Domain\Contracts\MainContract;
use App\Jobs\SmsNotification;
use App\Mail\NotificationMail;
use App\Mail\RegistrationMail;
use App\Models\User;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserRepositoryEloquent implements UserRepositoryInterface
{

    public function getByPhoneOrEmailOrAlias($login): object|null
    {
        return User::with(MainContract::ROLES,MainContract::POSITIONS)
            ->where($login)
            ->first();
    }

    public function update($id,$data): ?object
    {
        User::where(MainContract::ID,$id)->update($data);
        return $this->getById($id);
    }

    public function getById($id): object|null
    {
        return User::with(MainContract::ROLES,MainContract::POSITIONS)
            ->where([
                [MainContract::ID,$id],
//                [MainContract::STATUS,1]
            ])->first();
    }

    public function getByRoleIds($ids)
    {
        return User::whereIn(MainContract::ROLE_ID,$ids)->get();
    }

    public function getByBin($bin)
    {
        return User::where([
            [MainContract::BIN,$bin],
            [MainContract::STATUS,1]
        ])->first();
    }


    public function getByPhone($phone): object|null
    {
        return User::with(MainContract::ROLES,MainContract::POSITIONS)
            ->where([
                [MainContract::PHONE,$phone],
                [MainContract::STATUS,1]
            ])->first();
    }

    public function getByToken($token): object|null
    {
        return User::with(MainContract::ROLES,MainContract::POSITIONS)
            ->where([
                [MainContract::TOKEN,$token],
                [MainContract::STATUS,MainContract::TRUE]
            ])
            ->first();
    }

    public function registration($data) {

        $data[MainContract::POSITION_ID] = 1;
        $data[MainContract::ROLE_ID] = 5;
        $data[MainContract::EMAIL_CODE] =  rand(1000,9999);
        $data[MainContract::PHONE_CODE] =  rand(1000,9999);
        $data[MainContract::STATUS]    =   0;

//        $user = User::create($data);

        if ($user->{MainContract::EMAIL}) {
            $name   =   "новый пользователь";
            $title  =   'Регистрация на сайте CARCITY.KZ';
            $text   =   'Код для подтверждения почты: <span style="font-weight: bold; font-size:20px;">'.$data[MainContract::EMAIL_CODE].'</span>.';
            return new RegistrationMail($name,$title,$text);
            Mail::to($user->{MainContract::EMAIL})->send(new RegistrationMail($name,$title,$text));
        }

        return $user;
    }
}
