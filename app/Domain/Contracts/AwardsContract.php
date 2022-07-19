<?php

namespace App\Domain\Contracts;

class AwardsContract extends MainContract
{
    const TABLE =   'awards';
    const FILLABLE  =   [
        self::IMG,
        self::TITLE,
        self::TITLE_KZ,
        self::STATUS
    ];
}
