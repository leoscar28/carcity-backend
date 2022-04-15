<?php

namespace App\Helpers;

use Mobizon\Mobizon_Http_Error;
use Mobizon\Mobizon_Param_Required;
use Mobizon\MobizonApi;

class Sms
{
    const NAME      =   'CarCity';
    const API_KEY   =   'kz594a3ab8bd76dad07dc81cd72294043428aaf9bf78482a834aea87e0158e5f876c3b';
    const DOMAIN    =   'api.mobizon.kz';
    /**
     * @throws Mobizon_Http_Error
     * @throws Mobizon_Param_Required
     */
    static function send($phone, $code)
    {
        $api = new MobizonApi(self::API_KEY, self::DOMAIN);
        $api->call('message',
            'sendSMSMessage',
            [
                'recipient' => '7'.$phone,
                'text' => 'Ваш код '.$code,
                'from' => self::NAME,
                //Optional, if you don't have registered alphaname, just skip this param and your message will be sent with our free common alphaname.
            ]);
    }
}
