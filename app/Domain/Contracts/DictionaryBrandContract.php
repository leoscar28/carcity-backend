<?php

namespace App\Domain\Contracts;

class DictionaryBrandContract extends MainContract
{
    const TABLE =   'dictionary_brands';
    const FILLABLE  =   [
        self::NAME,
        self::STATUS,
        self::FOR_MENU
    ];
}
