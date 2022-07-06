<?php


namespace App\Domain\Contracts;


class UserRequestContract extends MainContract
{
    const TABLE =   'user_requests';

    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 40;

    const FILLABLE  =   [
        self::USER_ID,
        self::PHONE,
        self::CATEGORY_ID,
        self::BRAND_ID,
        self::DESCRIPTION,
        self::STATUS
    ];
}
