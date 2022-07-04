<?php

namespace App\Domain\Contracts;

class ContactContract extends MainContract
{
    const TABLE =   'contacts';
    const FILLABLE  =   [
        self::PHONE,
        self::STATUS
    ];
}
