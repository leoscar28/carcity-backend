<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Services\CompletionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CompletionFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $completion;
    protected $xml;
    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($completion,$user,$xml)
    {
        $this->completion   =   $completion;
        $this->user =   $user;
        $this->xml  =   $xml;
    }

    /**
     * Execute the job.
     *
     * @param CompletionService $completionService
     * @return void
     */
    public function handle(CompletionService $completionService): void
    {
        try {
            if (Storage::disk('public')->exists($this->completion->{MainContract::CUSTOMER_ID}.'/completions/'.$this->completion->{MainContract::ID}.'.pdf')) {
                Storage::disk('public')->move($this->completion->{MainContract::CUSTOMER_ID}.'/completions/'.$this->completion->{MainContract::ID}.'.pdf', $this->completion->{MainContract::CUSTOMER_ID}.'/completions/'.$this->completion->{MainContract::ID}.'/'.$this->completion->{MainContract::ID}.'.pdf');
            }
            Storage::disk('public')->put($this->completion->{MainContract::CUSTOMER_ID}.'/completions/'.$this->completion->{MainContract::ID}.'/Подпись 1 - '.$this->user->{MainContract::SURNAME}.' '.$this->user->{MainContract::NAME}.'/'.$this->user->{MainContract::ID}.'_'.$this->completion->{MainContract::ID}.'.xml', $this->xml);
        } catch (\Exception $exception) {
            $completionService->update($this->completion->{MainContract::ID},[
                MainContract::UPLOAD_STATUS_ID  =>  1
            ]);
        }
    }
}
