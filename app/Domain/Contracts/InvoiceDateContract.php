<?php

namespace App\Domain\Contracts;

class InvoiceDateContract extends MainContract
{
    const TABLE =   'invoice_dates';
    const FILLABLE  =   [
        self::UPLOAD_STATUS_ID,
        self::RID,
        self::DOCUMENT_ALL,
        self::DOCUMENT_AVAILABLE,
        self::COMMENT,
        self::STATUS
    ];
}
