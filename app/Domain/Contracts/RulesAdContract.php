<?php

namespace App\Domain\Contracts;

class RulesAdContract extends MainContract
{
    const TABLE =   'rules_ads';
    const FILLABLE  =   [
        self::BODY,
        self::BODY_KZ,
        self::STATUS
    ];
}
