<?php

namespace App\Domain\Contracts;

class UploadStatusContract extends MainContract
{
    const TABLE =   'upload_statuses';
    const FILLABLE  =   [
        self::TITLE,
        self::STATUS
    ];
}
