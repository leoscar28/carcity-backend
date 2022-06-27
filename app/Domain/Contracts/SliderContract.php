<?php

namespace App\Domain\Contracts;

class SliderContract extends MainContract
{
    const TABLE =   'sliders';
    const FILLABLE  =   [
        self::TITLE,
        self::TITLE_KZ,
        self::IMG,
        self::STATUS
    ];
}
