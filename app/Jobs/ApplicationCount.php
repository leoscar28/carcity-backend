<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Services\ApplicationDateService;
use App\Services\ApplicationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ApplicationCount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $rid;

    public function __construct(int $rid)
    {
        $this->rid  =   $rid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ApplicationService $applicationService, ApplicationDateService $applicationDateService)
    {
        $applicationList    =   $applicationService->list($this->rid);
        if ($applicationDate = $applicationDateService->getByRid($this->rid)) {
            $applicationDate->{MainContract::UPLOAD_STATUS_ID}  =   $applicationList[MainContract::UPLOAD_STATUS_ID];
            $applicationDate->{MainContract::DOCUMENT_ALL}  =   $applicationList[MainContract::DOCUMENT_ALL];
            if ($applicationList[MainContract::DOCUMENT_ALL] === 0) {
                $applicationDate->{MainContract::STATUS}    =   0;
            }
            $applicationDate->save();
        } else {
            $applicationDateService->create([
                MainContract::UPLOAD_STATUS_ID  =>  $applicationList[MainContract::UPLOAD_STATUS_ID],
                MainContract::RID   =>  $this->rid,
                MainContract::DOCUMENT_ALL  =>  $applicationList[MainContract::DOCUMENT_ALL],
            ]);
        }
    }
}
