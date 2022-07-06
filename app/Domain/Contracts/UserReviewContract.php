<?php


namespace App\Domain\Contracts;


class UserReviewContract extends MainContract
{
    const TABLE =   'user_reviews';

    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 40;

    const FILLABLE  =   [
        self::USER_ID,
        self::CUSTOMER_ID,
        self::USER_BANNER_ID,
        self::RATING,
        self::DESCRIPTION,
        self::COMMENT,
        self::STATUS
    ];
}
