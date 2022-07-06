<?php

namespace App\Domain\Contracts;

class UserContract extends MainContract
{
    const TABLE =   self::USERS;
    const FILLABLE  =   [
        self::TYPE,
        self::POSITION_ID,
        self::ALIAS,
        self::TOKEN,
        self::NAME,
        self::SURNAME,
        self::LAST_NAME,
        self::BIRTHDATE,
        self::HIDE_BIRTHDATE,
        self::ROLE_ID,
        self::COMPANY,
        self::BIN,
        self::EMAIL,
        self::EMAIL_CODE,
        self::EMAIL_VERIFIED_AT,
        self::PHONE,
        self::PHONE_CODE,
        self::PHONE_VERIFIED_AT,
        self::PASSWORD,
        self::STATUS,
        self::LIMIT
    ];
    const HIDDEN    =   [
        self::PASSWORD,
        self::REMEMBER_TOKEN
    ];
    const CASTS =   [
        self::EMAIL_VERIFIED_AT =>  self::DATETIME
    ];
}
