<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Helpers\File;
use App\Services\CompletionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CompletionFileCache implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $completion;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($completion)
    {
        $this->completion   =   $completion;
    }

    /**
     * Execute the job.
     *
     * @param CompletionService $completionService
     * @param File $file
     * @return void
     */
    public function handle(CompletionService $completionService, File $file): void
    {
        if ($file   =   $file->completion($this->completion)) {
            $completionService->update($this->completion->{MainContract::ID},[
                MainContract::FILE  =>  $file
            ]);
        }
    }
}
