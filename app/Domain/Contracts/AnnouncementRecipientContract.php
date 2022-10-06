<?php

namespace App\Domain\Contracts;

class AnnouncementRecipientContract extends MainContract
{
    const TABLE =   'announcement_recipients';

    const FILLABLE  =   [
        self::ANNOUNCEMENT_ID,
        self::USER_ID,
        self::VIEW
    ];
}
