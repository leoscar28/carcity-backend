<?php

namespace App\Domain\Contracts;

class ApplicationStatusContract extends MainContract
{
    const TABLE =   'application_statuses';
    const FILLABLE  =   [
        self::TITLE,
        self::STATUS
    ];
}
