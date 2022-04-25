<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Events\InvoiceTenantEvent;
use App\Events\NotificationTenantEvent;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Http\Resources\NotificationTenant\NotificationTenantResource;
use App\Services\InvoiceService;
use App\Services\NotificationTenantService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteInvoiceTenant implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $rid;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($rid)
    {
        $this->rid  =   $rid;
    }

    /**
     * Execute the job.
     *
     * @param InvoiceService $invoiceService
     * @param NotificationTenantService $notificationTenantService
     * @return void
     */
    public function handle(InvoiceService $invoiceService, NotificationTenantService $notificationTenantService): void
    {
        $invoices   =   $invoiceService->getByRid($this->rid);
        foreach ($invoices as &$invoice) {
            $invoice->{MainContract::STATUS} =   0;
            $invoice->save();
            $notificationTenants    =   $notificationTenantService->getByData([
                MainContract::INVOICE_ID    =>  $invoice->{MainContract::ID}
            ]);
            foreach ($notificationTenants as &$notificationTenant) {
                $notificationTenant->{MainContract::STATUS} =   0;
                $notificationTenant->save();
                event(new NotificationTenantEvent(new NotificationTenantResource($notificationTenant)));
            }
            event(new InvoiceTenantEvent(new InvoiceResource($invoice)));
        }
    }
}
