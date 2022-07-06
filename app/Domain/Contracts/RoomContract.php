<?php

namespace App\Domain\Contracts;

class RoomContract extends MainContract
{
    const TABLE =   'rooms';
    const FILLABLE  =   [
        self::TIER_ID,
        self::ROOM_TYPE_ID,
        self::USER_ID,
        self::TITLE,
        self::STATUS
    ];
}
