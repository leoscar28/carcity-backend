<?php

namespace App\Helpers;

class SmsHelper
{
    const LOGIN =   'waki';
    const PASSWORD  =   'bcd06adcb6fa4074b18ecb88fa82786d';
    const URL   =   'https://smsc.kz/sys/send.php?';

    public function send($phone,$message)
    {
        file_get_contents(self::URL.http_build_query([
            'login' =>  self::LOGIN,
            'psw'   =>  self::PASSWORD,
            'phones'    =>  '7'.$phone,
            'mes'   =>  $message
        ]),false,stream_context_create([
            'http' => [
                'method'=>"GET",
            ]
        ]));
    }

    public function phoneCodeVerify($code): string
    {
        return $code.' - Ваш проверочный код';
    }

}
