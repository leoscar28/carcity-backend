<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Events\InvoiceTenantEvent;
use App\Events\NotificationTenantEvent;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Services\NotificationTenantService;
use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InvoiceTenant implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $invoice;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($invoice)
    {
        $this->invoice  =   $invoice;
    }

    /**
     * Execute the job.
     *
     * @param UserService $userService
     * @param NotificationTenantService $notificationTenantService
     * @return void
     */
    public function handle(UserService $userService, NotificationTenantService $notificationTenantService): void
    {
        if ($user = $userService->getByBin($this->invoice->{MainContract::CUSTOMER_ID})) {
            if ($notificationTenant = $notificationTenantService->create([
                MainContract::USER_ID   =>  $user->{MainContract::ID},
                MainContract::TYPE  =>  1,
                MainContract::INVOICE_ID    =>  $this->invoice->{MainContract::ID},
                MainContract::VIEW  =>  0,
            ])) {
                event(new NotificationTenantEvent($notificationTenant));
            }
            event(new InvoiceTenantEvent(new InvoiceResource($this->invoice)));
        }
    }
}
