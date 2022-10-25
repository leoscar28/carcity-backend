<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserBannerContract;
use App\Events\NotificationTenantEvent;
use App\Services\NotificationService;
use App\Services\NotificationTenantService;
use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserBannerUnpublishJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $userBanner;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userBanner)
    {
        $this->userBanner  =   $userBanner;
    }

    /**
     * Execute the job.
     *
     * @param UserService $userService
     * @param NotificationTenantService $notificationTenantService
     * @param NotificationService $notificationService
     * @return void
     */
    public function handle(UserService $userService, NotificationTenantService $notificationTenantService, NotificationService $notificationService): void
    {
        if ($user = $userService->getById($this->userBanner->{MainContract::USER_ID})) {
            if ($notificationTenant = $notificationTenantService->create([
                MainContract::USER_ID   =>  $user->{MainContract::ID},
                MainContract::TYPE  =>  UserBannerContract::STATUS_FOR_UNPUBLISH,
                MainContract::USER_BANNER_ID    =>  $this->userBanner->{MainContract::ID},
                MainContract::VIEW  =>  0,
                MainContract::STATUS => 1
            ])) {
                event(new NotificationTenantEvent($notificationTenant));
            }
        }
    }
}
