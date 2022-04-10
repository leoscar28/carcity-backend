<?php

namespace App\Observers;

use App\Domain\Contracts\MainContract;
use App\Jobs\ApplicationCount;
use App\Jobs\CompletionCount;
use App\Jobs\InvoiceCount;
use App\Models\User;
use App\Services\ApplicationService;
use App\Services\CompletionService;
use App\Services\InvoiceService;

class UserObserver
{
    protected ApplicationService $applicationService;
    protected CompletionService $completionService;
    protected InvoiceService $invoiceService;

    public function __construct(ApplicationService $applicationService, CompletionService $completionService, InvoiceService $invoiceService)
    {
        $this->applicationService   =   $applicationService;
        $this->completionService    =   $completionService;
        $this->invoiceService   =   $invoiceService;
    }
    /**
     * Handle the User "created" event.
     *
     * @param User $user
     * @return void
     */
    public function created(User $user)
    {
        $applications   =   $this->applicationService->getByCustomerId($user->{MainContract::BIN});
        foreach ($applications as &$application) {
            ApplicationCount::dispatch($application->{MainContract::RID});
        }
        $completions    =   $this->completionService->getByCustomerId($user->{MainContract::BIN});
        foreach ($completions as &$completion) {
            CompletionCount::dispatch($completion->{MainContract::RID});
        }
        $invoices   =   $this->invoiceService->getByCustomerId($user->{MainContract::BIN});
        foreach ($invoices as &$invoice) {
            InvoiceCount::dispatch($invoice->{MainContract::RID});
        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param User $user
     * @return void
     */
    public function updated(User $user)
    {

    }

    /**
     * Handle the User "deleted" event.
     *
     * @param User $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param User $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param User $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
