<?php

namespace App\Jobs;

use App\Helpers\File;
use App\Helpers\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CompletionFiles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $completion;
    protected $xml;
    protected $user;
    protected $result;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($completion,$user,$xml,$result)
    {
        $this->completion   =   $completion;
        $this->user =   $user;
        $this->xml  =   $xml;
        $this->result   =   $result;
    }

    /**
     * Execute the job.
     *
     * @param File $file
     * @param Pdf $pdf
     * @return void
     */
    public function handle(File $file, Pdf $pdf): void
    {
        try {
            $file->completionFolder($this->completion);
            $file->completionXml($this->completion, $this->user, $this->xml);
            $file->completionCopy($this->completion);
            $pdf->signFile($this->completion, $this->xml, $this->result);
        } catch (\Exception $exception) {
            Log::info('err Completion Files',[$exception]);
        }
    }
}
