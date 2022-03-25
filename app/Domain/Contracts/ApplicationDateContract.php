<?php

namespace App\Domain\Contracts;

class ApplicationDateContract extends MainContract
{
    const TABLE =   'application_dates';
    const FILLABLE  =   [
        self::UPLOAD_STATUS_ID,
        self::RID,
        self::DOCUMENT_ALL,
        self::DOCUMENT_AVAILABLE,
        self::COMMENT,
        self::STATUS
    ];
}
