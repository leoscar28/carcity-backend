<?php


namespace App\Domain\Contracts;


class FeedbackRequestMessageContract extends MainContract
{
    const TABLE =   'feedback_request_messages';

    const FILLABLE  =   [
        self::USER_ID,
        self::FEEDBACK_REQUEST_ID,
        self::TYPE,
        self::DESCRIPTION
    ];
}
