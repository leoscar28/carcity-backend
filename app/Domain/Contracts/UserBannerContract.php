<?php


namespace App\Domain\Contracts;


class UserBannerContract extends MainContract
{
    const TABLE =   'user_banners';

    const STATUS_CREATED = 10;
    const STATUS_UPDATED = 15;
    const STATUS_NEED_EDITS = 20;
    const STATUS_NOT_PUBLISHED = 30;
    const STATUS_PUBLISHED = 31;
    const STATUS_INACTIVE = 40;

    const STATUS_FOR_UNPUBLISH = 999;

    const IS_NOT_PUBLISHED = 0;
    const IS_PUBLISHED = 1;

    const FILLABLE  =   [
        self::USER_ID,
        self::TYPE,
        self::TITLE,
        self::DESCRIPTION,
        self::ROOM_ID,
        self::CATEGORY_ID,
        self::BRAND_ID,
        self::TIME,
        self::WEEKDAYS,
        self::EMPLOYEE_NAME,
        self::EMPLOYEE_PHONE,
        self::EMPLOYEE_NAME_ADDITIONAL,
        self::EMPLOYEE_PHONE_ADDITIONAL,
        self::COMMENT,
        self::STATUS,
        self::IS_PUBLISHED,
        self::PUBLISHED_AT,
        self::UP
    ];
}
