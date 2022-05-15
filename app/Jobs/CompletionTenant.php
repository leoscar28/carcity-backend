<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Events\CompletionTenantEvent;
use App\Events\NotificationTenantEvent;
use App\Http\Resources\Completion\CompletionResource;
use App\Services\NotificationTenantService;
use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CompletionTenant implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $completion;
    public $type;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($completion,$type)
    {
        $this->completion   =   $completion;
        $this->type =   $type;
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
        if ($user = $userService->getByBin($this->completion->{MainContract::CUSTOMER_ID})) {
            if ($notificationTenant = $notificationTenantService->create([
                MainContract::USER_ID   =>  $user->{MainContract::ID},
                MainContract::TYPE  =>  $this->type,
                MainContract::COMPLETION_ID =>  $this->completion->{MainContract::ID},
                MainContract::VIEW  =>  0,
            ])) {
                event(new NotificationTenantEvent($notificationTenant));
            }
            event(new CompletionTenantEvent(new CompletionResource($this->completion)));
        }
    }
}
