<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Events\CompletionTenantEvent;
use App\Events\NotificationTenantEvent;
use App\Http\Resources\Completion\CompletionResource;
use App\Mail\NotificationMail;
use App\Services\NotificationTenantService;
use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

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
            if ($user->{MainContract::EMAIL}) {
                $name   =   $user->{MainContract::NAME}.' '.$user->{MainContract::SURNAME};
                $title  =   'Новые акты выполненных работ';
                $text   =   'Уведомляем Вас о новых актах выполненных работ в личном кабинете.
            В меню <b>«Акты выполненных работ»</b> подпишите документы с ЭЦП.';
                $link   =   '<a href="https://carcity.kz/dashboard" style="text-decoration: none; color: #274985;" target="_blank">https://carcity.kz/dashboard</a>';
                Mail::to($user->{MainContract::EMAIL})->send(new NotificationMail($name,$title,$text,$link));
            }
            event(new CompletionTenantEvent(new CompletionResource($this->completion)));
        }
    }
}
