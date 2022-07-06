<?php

namespace App\Console\Commands;

use App\Models\UserBanner;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UnsetUpUserBanner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:unset-up';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        UserBanner::where('up', '=', 1)
            ->update(
                ['up' => 0, 'updated_at' => DB::raw('updated_at')]
            );
        return 'Done';
    }
}
