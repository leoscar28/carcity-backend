<?php

namespace App\Console\Commands;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserBannerContract;
use App\Jobs\UserBannerUnpublishJob;
use App\Models\UserBanner;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UnpublishUserBanner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:unpublish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unpublish user banners who published  > 1 month';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $banners = UserBanner::where('status', '=', UserBannerContract::STATUS_PUBLISHED)
            ->whereBetween(MainContract::PUBLISHED_AT, [now()->subDays(88), now()->subDays(87)])->get();

        foreach ($banners as $banner) {
            UserBannerUnpublishJob::dispatch($banner);
        }

        UserBanner::where('status', '=', UserBannerContract::STATUS_PUBLISHED)
            ->where(MainContract::PUBLISHED_AT, '<', now()->subDays(90))
            ->update(
                ['status' => UserBannerContract::STATUS_INACTIVE, 'updated_at' => DB::raw('updated_at')]
            );
        return 'Done';
    }
}
