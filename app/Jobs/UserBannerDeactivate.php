<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserBannerContract;
use App\Events\InvoiceTenantEvent;
use App\Events\NotificationEvent;
use App\Events\NotificationTenantEvent;
use App\Events\UserBannerTenantEvent;
use App\Http\Resources\Invoice\InvoiceResource;
use App\Http\Resources\Notification\NotificationResource;
use App\Http\Resources\UserBanner\UserBannerResource;
use App\Mail\NotificationMail;
use App\Models\UserBanner;
use App\Services\NotificationService;
use App\Services\NotificationTenantService;
use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserBannerDeactivate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id)
    {
        $this->user_id  =   $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        UserBanner::where(MainContract::USER_ID, '=', $this->user_id)
            ->update(
                [MainContract::STATUS => UserBannerContract::STATUS_INACTIVE]
            );
    }
}
