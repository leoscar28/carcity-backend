<?php

namespace App\Domain\Contracts;

class PositionContract extends MainContract
{
    const TABLE =   'positions';
    const FILLABLE  =   [
        self::TITLE,
        self::STATUS
    ];
}
