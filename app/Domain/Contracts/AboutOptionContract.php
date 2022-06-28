<?php

namespace App\Domain\Contracts;

class AboutOptionContract extends MainContract
{
    const TABLE =   'about_options';
    const FILLABLE  =   [
        self::TITLE,
        self::TITLE_KZ,
        self::IMG,
        self::STATUS
    ];
}
