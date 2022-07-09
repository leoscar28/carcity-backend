<?php

namespace App\Domain\Contracts;

class RuleContract extends MainContract
{
    const TABLE =   'rules';
    const FILLABLE  =   [
        self::BODY,
        self::BODY_KZ,
        self::STATUS
    ];
}
