<?php

namespace App\Domain\Contracts;

class CompletionListContract extends MainContract
{
    const TABLE =   'completion_lists';
    const FILLABLE  =   [
        self::COMPLETION_ID,
        self::CUSTOMER,
        self::CUSTOMER_ID,
        self::NUMBER,
        self::ORGANIZATION,
        self::DATE,
        self::SUM,
        self::NAME,
        self::STATUS
    ];
}
