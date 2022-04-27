<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Events\ApplicationDateEvent;
use App\Events\CompletionDateEvent;
use App\Events\NotificationEvent;
use App\Http\Resources\ApplicationDate\ApplicationDateResource;
use App\Http\Resources\CompletionDate\CompletionDateResource;
use App\Http\Resources\CompletionDate\CompletionDateWithoutRelationResource;
use App\Http\Resources\Notification\NotificationResource;
use App\Services\CompletionDateService;
use App\Services\CompletionService;
use App\Services\NotificationService;
use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CompletionCount implements ShouldQueue
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
    public function handle(CompletionService $completionService,CompletionDateService $completionDateService, UserService $userService, NotificationService $notificationService): void
    {
        if ($completionList =   $completionService->list($this->rid)) {
            if ($completionDate =   $completionDateService->getByRid($this->rid)) {
                $completionDate->{MainContract::UPLOAD_STATUS_ID}   =   $completionList[MainContract::UPLOAD_STATUS_ID];
                $completionDate->{MainContract::DOCUMENT_ALL}   =   $completionList[MainContract::DOCUMENT_ALL];
                $completionDate->{MainContract::DOCUMENT_AVAILABLE} =   $completionList[MainContract::DOCUMENT_AVAILABLE];
                if ($completionList[MainContract::DOCUMENT_ALL] === 0) {
                    $completionDate->{MainContract::STATUS} =   0;
                } else {
                    $completionDate->{MainContract::STATUS} =   1;
                }
                $completionDate->save();

                if ($completionList[MainContract::UPLOAD_STATUS_ID] === 3) {
                    $users  =   $userService->getByRoleIds([2,3,4]);
                    foreach ($users as &$user) {
                        $notification = $notificationService->create([
                            MainContract::USER_ID   =>  $user->{MainContract::ID},
                            MainContract::TYPE  =>  2,
                            MainContract::COMPLETION_ID =>  $completionDate->{MainContract::ID},
                            MainContract::VIEW  =>  0,
                        ]);
                        event(new NotificationEvent(new NotificationResource($notification)));
                    }
                }
                event(new CompletionDateEvent(new CompletionDateWithoutRelationResource($completionDate)));
            } else {
                $data   =   [
                    MainContract::UPLOAD_STATUS_ID  =>  $completionList[MainContract::UPLOAD_STATUS_ID],
                    MainContract::RID   =>  $this->rid,
                    MainContract::DOCUMENT_ALL  =>  $completionList[MainContract::DOCUMENT_ALL],
                    MainContract::DOCUMENT_AVAILABLE    =>  $completionList[MainContract::DOCUMENT_AVAILABLE],
                ];
                if ($completionList[MainContract::DOCUMENT_ALL] === 0) {
                    $data[MainContract::STATUS] =   0;
                }
                if ($completionDate = $completionDateService->create($data)) {
                    $users  =   $userService->getByRoleIds([2,3,4]);
                    foreach ($users as &$user) {
                        $notification = $notificationService->create([
                            MainContract::USER_ID   =>  $user->{MainContract::ID},
                            MainContract::TYPE  =>  1,
                            MainContract::COMPLETION_ID =>  $completionDate->{MainContract::ID},
                            MainContract::VIEW  =>  0,
                        ]);
                        event(new NotificationEvent(new NotificationResource($notification)));
                    }
                    event(new CompletionDateEvent(new CompletionDateWithoutRelationResource($completionDate)));
                }
            }
        }
    }
}
