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

        $userEmails = $users->pluck(MainContract::EMAIL)->toArray();

        $name = $data[MainContract::TO] == 1 ? 'уважаемый арендатор' : 'уважаемый пользовтель';

        if (count($userEmails) > 0) {
            $firstEmail = $userEmails[0];
            unset($userEmails[0]);

            Mail::to($firstEmail)
                ->bcc($userEmails)
                ->send(new NotificationMail($name,$data[MainContract::TITLE],$data[MainContract::TEXT],''));

            return true;
        }

        return false;

    }
}
