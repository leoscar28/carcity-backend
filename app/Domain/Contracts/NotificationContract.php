<?php

namespace App\Domain\Contracts;

class NotificationContract extends MainContract
{
    const TABLE =   'notifications';
    const FILLABLE  =   [
        self::USER_ID,
        self::FOREIGN_ID,
        self::TYPE,
        self::VIEW,
        self::STATUS
    ];
}
