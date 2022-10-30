<?php

namespace App\Domain\Contracts;

class DictionarySparePartContract extends MainContract
{
    const TABLE =   'dictionary_spare_parts';
    const FILLABLE  =   [
        self::NAME,
        self::NAME_KZ,
        self::STATUS,
        self::FOR_MENU
    ];
}
