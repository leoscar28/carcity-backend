<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Events\ApplicationTenantEvent;
use App\Events\NotificationTenantEvent;
use App\Http\Resources\Application\ApplicationResource;
use App\Http\Resources\NotificationTenant\NotificationTenantResource;
use App\Services\ApplicationService;
use App\Services\NotificationTenantService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteApplicationTenant implements ShouldQueue
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
     * @param ApplicationService $applicationService
     * @param NotificationTenantService $notificationTenantService
     * @return void
     */
    public function handle(ApplicationService $applicationService, NotificationTenantService $notificationTenantService): void
    {
        $applications   =   $applicationService->getByRid($this->rid);
        foreach ($applications as &$application) {
            $application->{MainContract::STATUS}    =   0;
            $application->save();
            $notificationTenants    =   $notificationTenantService->getByData([
                MainContract::APPLICATION_ID    =>  $application->{MainContract::ID}
            ]);
            foreach ($notificationTenants as &$notificationTenant) {
                $notificationTenant->{MainContract::STATUS} =   0;
                $notificationTenant->save();
                event(new NotificationTenantEvent(new NotificationTenantResource($notificationTenant)));
            }
            event(new ApplicationTenantEvent(new ApplicationResource($application)));
        }
    }
}
