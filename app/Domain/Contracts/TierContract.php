<?php

namespace App\Domain\Contracts;

class TierContract extends MainContract
{
    const TABLE =   'tiers';
    const FILLABLE  =   [
        MainContract::TITLE,
        MainContract::TITLE_KZ,
        MainContract::STATUS
    ];
}
