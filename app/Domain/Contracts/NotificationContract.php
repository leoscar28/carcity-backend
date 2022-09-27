<?php

namespace App\Domain\Contracts;

class NotificationContract extends MainContract
{
    const TABLE =   self::NOTIFICATIONS;
    const FILLABLE  =   [
        self::USER_ID,
        self::TYPE,
        self::APPLICATION_ID,
        self::COMPLETION_ID,
        self::INVOICE_ID,
        self::USER_BANNER_ID,
        self::USER_REVIEW_ID,
        self::USER_REQUEST_ID,
        self::FEEDBACK_REQUEST_ID,
        self::VIEW,
        self::STATUS
    ];
}
