<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Events\InvoiceTenantEvent;
use App\Events\NotificationEvent;
use App\Events\NotificationTenantEvent;
use App\Events\UserBannerTenantEvent;
use App\Events\UserReviewTenantEvent;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Http\Resources\Notification\NotificationResource;
use App\Http\Resources\UserBanner\UserBannerResource;
use App\Http\Resources\UserReview\UserReviewResource;
use App\Mail\NotificationMail;
use App\Services\NotificationService;
use App\Services\NotificationTenantService;
use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UserRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $userRequest;
    public $type;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userRequest, $type = 1)
    {
        $this->userRequest  =   $userRequest;
        $this->type  =   $type;
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
        $users  =   $userService->getByRoleIds([1]);
        foreach ($users as &$user) {
            if ($notificationTenant = $notificationTenantService->create([
                MainContract::USER_ID => $user->{MainContract::ID},
                MainContract::TYPE => $this->type,
                MainContract::USER_REQUEST_ID => $this->userRequest->{MainContract::ID},
                MainContract::VIEW => 0,
                MainContract::STATUS => 1
            ])) {
                event(new NotificationTenantEvent($notificationTenant));
            }
        }

        $users  =   $userService->getByRoleIds([2]);
        foreach ($users as &$user) {
            $notification = $notificationService->create([
                MainContract::USER_ID   =>  $user->{MainContract::ID},
                MainContract::TYPE  =>  $this->type,
                MainContract::USER_REQUEST_ID    =>  $this->userRequest->{MainContract::ID},
                MainContract::VIEW  =>  0,
                MainContract::STATUS => 1
            ]);
            event(new NotificationEvent(new NotificationResource($notification)));
        }
    }
}
