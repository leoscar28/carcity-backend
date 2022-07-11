<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\MailingRequest;
use App\Mail\NotificationMail;
use App\Services\UserService;
use Illuminate\Support\Facades\Mail;

class MailingController extends Controller
{

    protected UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService   =   $userService;
    }

    public function sendMail(MailingRequest $request)
    {
        $data = $request->check();

        $users = $this->userService->getByRoleIds([$data[MainContract::TO]]);

        $users = $users->filter(function ($value, $key) {
            return $value->email;
        });

        $userEmails = $users->pluck(MainContract::EMAIL)->toArray();

        $name = $data[MainContract::TO] == 1 ? 'уважаемый арендатор' : 'уважаемый пользовтель';

        if (count($userEmails) > 0) {
            $email_chunks = array_chunk($userEmails, 100);

            foreach ($email_chunks as $email_chunk){
                $firstEmail = $email_chunk[0];
                unset($email_chunk[0]);

                Mail::to($firstEmail)
                    ->bcc(array_values($email_chunk))
                    ->queue(new NotificationMail($name,$data[MainContract::TITLE],$data[MainContract::TEXT],''));
            }

            return true;
        }

        return false;

    }
}
