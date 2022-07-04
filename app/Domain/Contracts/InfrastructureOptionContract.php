<?php

namespace App\Domain\Contracts;

class InfrastructureOptionContract extends MainContract
{
    const TABLE =   'infrastructure_options';
    const FILLABLE  =   [
        self::TITLE,
        self::TITLE_KZ,
        self::IMG,
        self::STATUS,
    ];
}
