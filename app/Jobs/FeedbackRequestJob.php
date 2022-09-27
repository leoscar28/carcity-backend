<?php

namespace App\Jobs;

use App\Domain\Contracts\FeedbackRequestContract;
use App\Domain\Contracts\MainContract;
use App\Events\NotificationEvent;
use App\Http\Resources\Notification\NotificationResource;
use App\Mail\NotificationMail;
use App\Services\NotificationService;
use App\Services\NotificationTenantService;
use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class FeedbackRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $feedbackRequest;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($feedbackRequest)
    {
        $this->feedbackRequest  =   $feedbackRequest;
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
        if ($this->feedbackRequest->{MainContract::STATUS} === FeedbackRequestContract::STATUS_ANSWER) {
            $user = $userService->getById($this->feedbackRequest->{MainContract::USER_ID});
            if ($user->{MainContract::EMAIL}) {
                $name   =   $user->{MainContract::NAME}.' '.$user->{MainContract::SURNAME};
                $title  =   '(Запрос №'.$this->feedbackRequest->{MainContract::ID}.') Тема: '.$this->feedbackRequest->{MainContract::TITLE};
                $text   =   'Уведомляем Вас о том что запрос №'.$this->feedbackRequest->{MainContract::ID}.' обработан';
                $link   =   '<a href="https://carcity.kz/profile/feedback/'.$this->feedbackRequest->{MainContract::ID}.'" style="text-decoration: none; color: #274985;" target="_blank">https://carcity.kz/profile/feedback</a>';
                Mail::to($user->{MainContract::EMAIL})->send(new NotificationMail($name,$title,$text,$link));
            }
        } else if (in_array($this->feedbackRequest->{MainContract::STATUS}, [FeedbackRequestContract::STATUS_NEW, FeedbackRequestContract::STATUS_ANSWER_CLIENT, FeedbackRequestContract::STATUS_CLOSE])) {
            $users  =   $userService->getByRoleIds([2]);

            foreach ($users as $user) {
                $notification = $notificationService->create([
                    MainContract::USER_ID   =>  $user->{MainContract::ID},
                    MainContract::TYPE  =>  $this->feedbackRequest->{MainContract::STATUS},
                    MainContract::FEEDBACK_REQUEST_ID    =>  $this->feedbackRequest->{MainContract::ID},
                    MainContract::VIEW  =>  0,
                    MainContract::STATUS => 1
                ]);
                event(new NotificationEvent(new NotificationResource($notification)));
            }
        }


    }
}
