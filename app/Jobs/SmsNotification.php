<?php

namespace App\Jobs;

use App\Helpers\SmsHelper;
use App\Helpers\SmsMobizon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SmsNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $phone;
    protected int $code;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $phone,int $code)
    {
        $this->phone    =   $phone;
        $this->code     =   $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SmsHelper $smsHelper)
    {
        $smsMobizon =   new SmsMobizon('kz594a3ab8bd76dad07dc81cd72294043428aaf9bf78482a834aea87e0158e5f876c3b', 'api.mobizon.kz',['format' => 'json']);
        if ($smsMobizon->call('message',
            'sendSMSMessage',
            array(
                'recipient' => '7'.$this->phone,
                'text' => $smsHelper->phoneCodeVerify($this->code),
                'from' => 'CARCITY.KZ',
            ))) {
            $messageId = $smsMobizon->getData('messageId');
            Log::info('message',[$messageId]);
        } else {
            Log::info('error',['An error occurred while sending message: [' . $smsMobizon->getCode() . '] ' . $smsMobizon->getMessage() . 'See details below:']);
        }
        //$smsHelper->send($this->phone,$smsHelper->phoneCodeVerify($this->code));
    }
}
