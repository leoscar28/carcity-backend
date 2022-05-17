<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Events\ApplicationTenantEvent;
use App\Events\NotificationTenantEvent;
use App\Http\Resources\Application\ApplicationResource;
use App\Http\Resources\NotificationTenant\NotificationTenantResource;
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
            if ($user->{MainContract::EMAIL}) {
                $name   =   $user->{MainContract::NAME}.' '.$user->{MainContract::SURNAME};
                $title  =   'Новые договоры';
                $text   =   'Уведомляем Вас о новых договорах в личном кабинете. В меню <b>«Договоры и приложения»</b> подпишите документы с ЭЦП.';
                $link   =   '<a href="https://carcity.kz/application" style="text-decoration: none; color: #274985;" target="_blank">https://carcity.kz/application</a>';
                Mail::to($user->{MainContract::EMAIL})->send(new NotificationMail($name,$title,$text,$link));
            }
            event(new ApplicationTenantEvent(new ApplicationResource($this->application)));
        }
    }
}
