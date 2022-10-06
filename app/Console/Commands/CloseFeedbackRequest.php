<?php

namespace App\Console\Commands;

use App\Domain\Contracts\FeedbackRequestContract;
use App\Domain\Contracts\MainContract;
use App\Models\FeedbackRequest;
use Illuminate\Console\Command;

class CloseFeedbackRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:close-feedback-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close feedback request answered > 1 day';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        FeedbackRequest::where(MainContract::STATUS, '=', FeedbackRequestContract::STATUS_ANSWER)
            ->where(MainContract::UPDATED_AT, '<', now()->subDays(1))
            ->update(
                ['status' => FeedbackRequestContract::STATUS_CLOSE]
            );
        return 'Done';
    }
}
