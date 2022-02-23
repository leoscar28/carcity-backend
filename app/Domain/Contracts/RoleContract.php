<?php

namespace App\Domain\Contracts;

class RoleContract extends MainContract
{
    const TABLE =   self::ROLES;
    const FILLABLE  =   [
        self::TITLE,
        self::STATUS
    ];
}
