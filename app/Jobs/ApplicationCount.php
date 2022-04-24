<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Events\ApplicationDateEvent;
use App\Events\NotificationEvent;
use App\Http\Resources\ApplicationDate\ApplicationDateResource;
use App\Http\Resources\Notification\NotificationResource;
use App\Services\ApplicationDateService;
use App\Services\ApplicationService;
use App\Services\NotificationService;
use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ApplicationCount implements ShouldQueue
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
    public function handle(ApplicationService $applicationService, ApplicationDateService $applicationDateService, UserService $userService, NotificationService $notificationService): void
    {
        if ($applicationList    =   $applicationService->list($this->rid)) {
            if ($applicationDate = $applicationDateService->getByRid($this->rid)) {
                $applicationDate->{MainContract::UPLOAD_STATUS_ID}  =   $applicationList[MainContract::UPLOAD_STATUS_ID];
                $applicationDate->{MainContract::DOCUMENT_ALL}  =   $applicationList[MainContract::DOCUMENT_ALL];
                $applicationDate->{MainContract::DOCUMENT_AVAILABLE}    =   $applicationList[MainContract::DOCUMENT_AVAILABLE];
                if ($applicationList[MainContract::DOCUMENT_ALL] === 0) {
                    $applicationDate->{MainContract::STATUS}    =   0;
                } else {
                    $applicationDate->{MainContract::STATUS}    =   1;
                }
                $applicationDate->save();
                if ($applicationList[MainContract::UPLOAD_STATUS_ID] === 3) {
                    $users  =   $userService->getByRoleIds([2,3,4]);
                    foreach ($users as &$user) {
                        $notification = $notificationService->create([
                            MainContract::USER_ID   =>  $user->{MainContract::ID},
                            MainContract::TYPE  =>  2,
                            MainContract::APPLICATION_ID    =>  $applicationDate->{MainContract::ID},
                            MainContract::VIEW  =>  0,
                        ]);
                        event(new NotificationEvent(new NotificationResource($notification)));
                    }
                }
                event(new ApplicationDateEvent(new ApplicationDateResource($applicationDate)));
            } else {
                $data   =   [
                    MainContract::UPLOAD_STATUS_ID  =>  $applicationList[MainContract::UPLOAD_STATUS_ID],
                    MainContract::RID   =>  $this->rid,
                    MainContract::DOCUMENT_ALL  =>  $applicationList[MainContract::DOCUMENT_ALL],
                    MainContract::DOCUMENT_AVAILABLE    =>  $applicationList[MainContract::DOCUMENT_AVAILABLE]
                ];
                if ($applicationList[MainContract::DOCUMENT_ALL] === 0) {
                    $data[MainContract::STATUS] =   0;
                }
                if ($applicationDate = $applicationDateService->create($data)) {
                    $users  =   $userService->getByRoleIds([2,3,4]);
                    foreach ($users as &$user) {
                        $notification = $notificationService->create([
                            MainContract::USER_ID   =>  $user->{MainContract::ID},
                            MainContract::TYPE  =>  1,
                            MainContract::APPLICATION_ID    =>  $applicationDate->{MainContract::ID},
                            MainContract::VIEW  =>  0,
                        ]);
                        event(new NotificationEvent(new NotificationResource($notification)));
                    }
                    event(new ApplicationDateEvent(new ApplicationDateResource($applicationDate)));
                }
            }
        }
    }
}
