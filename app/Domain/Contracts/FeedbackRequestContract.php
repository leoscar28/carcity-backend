<?php


namespace App\Domain\Contracts;


class FeedbackRequestContract extends MainContract
{
    const TABLE =   'feedback_requests';

    const STATUS_NEW = 10;
    const STATUS_ANSWER = 20;
    const STATUS_ANSWER_CLIENT = 30;
    const STATUS_CLOSE = 40;

    const FILLABLE  =   [
        self::USER_ID,
        self::TITLE,
        self::STATUS
    ];
}
