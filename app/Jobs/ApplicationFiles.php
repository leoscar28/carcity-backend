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
use App\Services\ApplicationService;

class ApplicationFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $application;
    protected $xml;
    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($application,$user,$xml)
    {
        $this->application  =   $application;
        $this->xml  =   $xml;
        $this->user =   $user;
    }

    /**
     * Execute the job.
     *
     * @param ApplicationService $applicationService
     * @return void
     */
    public function handle(ApplicationService $applicationService): void
    {
        try {
            if (Storage::disk('public')->exists($this->application->{MainContract::CUSTOMER_ID}.'/applications/'.$this->application->{MainContract::ID}.'.docx')) {
                Storage::disk('public')->move($this->application->{MainContract::CUSTOMER_ID}.'/applications/'.$this->application->{MainContract::ID}.'.docx', $this->application->{MainContract::CUSTOMER_ID}.'/applications/'.$this->application->{MainContract::ID}.'/'.$this->application->{MainContract::ID}.'.docx');
            }
            Storage::disk('public')->put($this->application->{MainContract::CUSTOMER_ID}.'/applications/'.$this->application->{MainContract::ID}.'/Подпись 1 - '.$this->user->{MainContract::SURNAME}.' '.$this->user->{MainContract::NAME}.'/'.$this->user->{MainContract::ID}.'_'.$this->application->{MainContract::ID}.'.xml', $this->xml);
        } catch (\Exception $exception) {
            $applicationService->update($this->application->{MainContract::ID},[
                MainContract::UPLOAD_STATUS_ID  =>  1
            ]);
        }
    }
}
