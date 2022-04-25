<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Events\CompletionTenantEvent;
use App\Events\NotificationTenantEvent;
use App\Http\Resources\Completion\CompletionResource;
use App\Http\Resources\NotificationTenant\NotificationTenantResource;
use App\Services\CompletionService;
use App\Services\NotificationTenantService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteCompletionTenant implements ShouldQueue
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
     * @param CompletionService $completionService
     * @param NotificationTenantService $notificationTenantService
     * @return void
     */
    public function handle(CompletionService $completionService, NotificationTenantService $notificationTenantService): void
    {
        $completions    =   $completionService->getByRid($this->rid);
        foreach ($completions as &$completion) {
            $completion->{MainContract::STATUS} =   0;
            $completion->save();
            $notificationTenants    =   $notificationTenantService->getByData([
                MainContract::COMPLETION_ID =>  $completion->{MainContract::ID}
            ]);
            foreach ($notificationTenants as &$notificationTenant) {
                $notificationTenant->{MainContract::STATUS} =   0;
                $notificationTenant->save();
                event(new NotificationTenantEvent(new NotificationTenantResource($notificationTenant)));
            }
             event(new CompletionTenantEvent(new CompletionResource($completion)));
        }
    }
}
