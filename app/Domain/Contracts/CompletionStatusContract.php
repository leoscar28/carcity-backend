<?php

namespace App\Domain\Contracts;

class CompletionStatusContract extends MainContract
{
    const TABLE =   'completion_statuses';
    const FILLABLE  =   [
        self::TITLE,
        self::STATUS
    ];
}
