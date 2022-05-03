<?php

namespace App\Domain\Contracts;

class CompletionSignatureContract extends MainContract
{
    const TABLE =   'completion_signatures';
    const FILLABLE  =   [
        self::COMPLETION_ID,
        self::USER_ID,
        self::SIGNATURE,
        self::DATA,
        self::STATUS,
    ];
}
