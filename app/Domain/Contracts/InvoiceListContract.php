<?php

namespace App\Domain\Contracts;

class InvoiceListContract extends MainContract
{
    const TABLE =   'invoice_lists';
    const FILLABLE  =   [
        self::INVOICE_ID,
        self::CUSTOMER,
        self::CUSTOMER_ID,
        self::NUMBER,
        self::ORGANIZATION,
        self::DATE,
        self::SUM,
        self::NAME,
        self::STATUS
    ];
}
