<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CompletionTenantFiles implements ShouldQueue
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
     * @return void
     */
    public function handle(): void
    {
        Storage::disk('public')->put($this->completion->{MainContract::CUSTOMER_ID}.'/completions/'.$this->completion->{MainContract::ID}.'/Подпись 2 - '.$this->user->{MainContract::SURNAME}.' '.$this->user->{MainContract::NAME}.'/'.$this->user->{MainContract::ID}.'_'.$this->completion->{MainContract::ID}.'.xml', $this->xml);
        CompletionSignatureArchive::dispatch($this->completion->{MainContract::ID});
    }
}
