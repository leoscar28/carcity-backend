<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Events\ApplicationTenantEvent;
use App\Events\NotificationTenantEvent;
use App\Http\Resources\Application\ApplicationResource;
use App\Http\Resources\NotificationTenant\NotificationTenantResource;
use App\Services\NotificationTenantService;
use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ApplicationTenant implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $application;
    public int $type;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($application,int $type)
    {
        $this->application  =   $application;
        $this->type = $type;
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
        if ($user = $userService->getByBin($this->application->{MainContract::CUSTOMER_ID})) {
            if ($notificationTenant = $notificationTenantService->create([
                MainContract::USER_ID   =>  $user->{MainContract::ID},
                MainContract::TYPE  =>  $this->type,
                MainContract::APPLICATION_ID    =>  $this->application->{MainContract::ID},
                MainContract::VIEW  =>  0,
            ])) {
                event(new NotificationTenantEvent(new NotificationTenantResource($notificationTenant)));
            }
            event(new ApplicationTenantEvent(new ApplicationResource($this->application)));
        }
    }
}
