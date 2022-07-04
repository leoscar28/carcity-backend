<?php

namespace App\Domain\Contracts;

class InfrastructureContract extends MainContract
{
    const TABLE =   'infrastructures';
    const FILLABLE  =   [
        self::TITLE,
        self::TITLE_KZ,
        self::DESCRIPTION,
        self::DESCRIPTION_KZ,
        self::STATUS
    ];
}
