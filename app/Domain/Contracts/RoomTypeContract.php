<?php

namespace App\Domain\Contracts;

class RoomTypeContract extends MainContract
{
    const TABLE =   'room_types';
    const FILLABLE  =   [
        self::TITLE,
        self::TITLE_KZ,
        self::STATUS
    ];
}
