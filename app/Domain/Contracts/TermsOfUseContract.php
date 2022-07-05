<?php

namespace App\Domain\Contracts;

class TermsOfUseContract extends MainContract
{
    const TABLE =   'terms_of_uses';
    const FILLABLE  =   [
        self::BODY,
        self::BODY_KZ,
        self::STATUS
    ];
}
