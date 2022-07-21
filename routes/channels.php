<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('applicationDate', function ($user, $applicationDate) {
    return true;
});
Broadcast::channel('completionDate', function ($user, $completionDate) {
    return true;
});
Broadcast::channel('invoiceDate', function ($user, $invoiceDate) {
    return true;
});

Broadcast::channel('userBannerDate', function ($user, $userBanner) {
    return true;
});

Broadcast::channel('application.{bin}', function ($user, $application) {
    return true;
});
Broadcast::channel('completion.{bin}', function ($user, $completion) {
    return true;
});
Broadcast::channel('invoice.{bin}', function ($user, $invoice) {
    return true;
});

Broadcast::channel('notification.{user_id}', function ($user, $notification) {
    return true;
});

Broadcast::channel('notificationTenant.{user_id}', function ($user, $notificationTenant) {
    return true;
});

Broadcast::channel('userBanner.{user_id}', function ($user, $userBanner) {
    return true;
});

Broadcast::channel('userReview.{user_id}', function ($user, $userReview) {
    return true;
});
