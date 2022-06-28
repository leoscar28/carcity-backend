<?php

namespace App\Domain\Contracts;

class AboutContract extends MainContract
{
    const TABLE =   'abouts';
    const FILLABLE  =   [
        self::TITLE,
        self::TITLE_KZ,
        self::DESCRIPTION,
        self::DESCRIPTION_KZ
    ];
}
