<?php

namespace App\Domain\Contracts;

class CompletionDateContract extends MainContract
{
    const TABLE =   'completion_dates';
    const FILLABLE  =   [
        self::UPLOAD_STATUS_ID,
        self::RID,
        self::DOCUMENT_ALL,
        self::DOCUMENT_AVAILABLE,
        self::COMMENT,
        self::STATUS
    ];
}
