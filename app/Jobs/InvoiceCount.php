<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Events\InvoiceDateEvent;
use App\Events\NotificationEvent;
use App\Http\Resources\InvoiceDate\InvoiceDateResource;
use App\Http\Resources\InvoiceDate\InvoiceDateWithoutRelationResource;
use App\Http\Resources\Notification\NotificationResource;
use App\Services\InvoiceDateService;
use App\Services\InvoiceService;
use App\Services\NotificationService;
use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InvoiceCount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $rid;
    public function __construct(int $rid)
    {
        $this->rid  =   $rid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(InvoiceService $invoiceService, InvoiceDateService $invoiceDateService, UserService $userService, NotificationService $notificationService): void
    {
        if ($invoiceList    =   $invoiceService->list($this->rid)) {
            if ($invoiceDate = $invoiceDateService->getByRid($this->rid)) {
                $invoiceDate->{MainContract::UPLOAD_STATUS_ID}  =   $invoiceList[MainContract::UPLOAD_STATUS_ID];
                $invoiceDate->{MainContract::DOCUMENT_ALL}  =   $invoiceList[MainContract::DOCUMENT_ALL];
                $invoiceDate->{MainContract::DOCUMENT_AVAILABLE}    =   $invoiceList[MainContract::DOCUMENT_AVAILABLE];
                if ($invoiceList[MainContract::DOCUMENT_ALL] === 0) {
                    $invoiceDate->{MainContract::STATUS}    =   0;
                } else {
                    $invoiceDate->{MainContract::STATUS}    =   1;
                }
                $invoiceDate->save();
                if ($invoiceList[MainContract::UPLOAD_STATUS_ID] === 3) {
                    $users  =   $userService->getByRoleIds([2,3,4]);
                    foreach ($users as &$user) {
                        $notification = $notificationService->create([
                            MainContract::USER_ID   =>  $user->{MainContract::ID},
                            MainContract::TYPE  =>  2,
                            MainContract::INVOICE_ID    =>  $invoiceDate->{MainContract::ID},
                            MainContract::VIEW  =>  0,
                        ]);
                        event(new NotificationEvent(new NotificationResource($notification)));
                    }
                }
                event(new InvoiceDateEvent(new InvoiceDateWithoutRelationResource($invoiceDate)));
            } else {
                $data   =   [
                    MainContract::UPLOAD_STATUS_ID  =>  $invoiceList[MainContract::UPLOAD_STATUS_ID],
                    MainContract::RID   =>  $this->rid,
                    MainContract::DOCUMENT_ALL  =>  $invoiceList[MainContract::DOCUMENT_ALL],
                    MainContract::DOCUMENT_AVAILABLE    =>  $invoiceList[MainContract::DOCUMENT_AVAILABLE]
                ];
                if ($invoiceList[MainContract::DOCUMENT_ALL] === 0) {
                    $data[MainContract::STATUS] =   0;
                }
                if ($invoiceDate = $invoiceDateService->create($data)) {
                    $users  =   $userService->getByRoleIds([2,3,4]);
                    foreach ($users as &$user) {
                        $notification = $notificationService->create([
                            MainContract::USER_ID   =>  $user->{MainContract::ID},
                            MainContract::TYPE  =>  1,
                            MainContract::INVOICE_ID    =>  $invoiceDate->{MainContract::ID},
                            MainContract::VIEW  =>  0,
                        ]);
                        event(new NotificationEvent(new NotificationResource($notification)));
                    }
                    event(new InvoiceDateEvent(new InvoiceDateWithoutRelationResource($invoiceDate)));
                }
            }
        }
    }
}
