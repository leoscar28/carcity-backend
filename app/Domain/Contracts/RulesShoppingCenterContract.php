<?php

namespace App\Domain\Contracts;

class RulesShoppingCenterContract extends MainContract
{
    const TABLE =   'rules_shopping_centers';
    const FILLABLE  =   [
        self::BODY,
        self::BODY_KZ,
        self::STATUS
    ];
}
