<?php

namespace App\Domain\Contracts;

class AnnouncementContract extends MainContract
{
    const TABLE =   'announcements';

    const FILLABLE  =   [
        self::TITLE,
        self::DESCRIPTION,
        self::LINK
    ];
}
