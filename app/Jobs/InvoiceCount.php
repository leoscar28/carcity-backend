<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Services\InvoiceDateService;
use App\Services\InvoiceService;
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
    public function handle(InvoiceService $invoiceService, InvoiceDateService $invoiceDateService)
    {
        $invoiceList    =   $invoiceService->list($this->rid);
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
            $invoiceDateService->create($data);
        }
    }
}
