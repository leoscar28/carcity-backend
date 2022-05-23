<?php

namespace App\Domain\Contracts;

class UserBinContract extends MainContract
{
    const TABLE =   'user_bins';
    const FILLABLE  =   [
        self::IIN,
        self::BIN,
        self::STATUS
    ];
}
