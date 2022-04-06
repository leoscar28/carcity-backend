<?php

namespace App\Domain\Contracts;

class ApplicationSignatureContract extends MainContract
{
    const TABLE =   'application_signatures';
    const FILLABLE  =   [
        self::APPLICATION_ID,
        self::USER_ID,
        self::SIGNATURE,
        self::DATA,
        self::STATUS,
    ];
}
