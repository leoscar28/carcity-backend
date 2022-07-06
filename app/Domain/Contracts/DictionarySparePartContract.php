<?php

namespace App\Domain\Contracts;

class DictionarySparePartContract extends MainContract
{
    const TABLE =   'dictionary_spare_parts';
    const FILLABLE  =   [
        self::NAME,
        self::STATUS,
        self::FOR_MENU
    ];
}
