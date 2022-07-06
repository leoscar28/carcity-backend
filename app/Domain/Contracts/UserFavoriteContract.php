<?php


namespace App\Domain\Contracts;


class UserFavoriteContract extends MainContract
{
    const TABLE =   'user_favorites';

    const FILLABLE  =   [
        self::USER_ID,
        self::USER_BANNER_ID
    ];
}
