<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Helpers\File;
use App\Helpers\Pdf;
use App\Services\CompletionSignatureService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CompletionTenantFiles implements ShouldQueue
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
            $file->completionXml($this->completion, $this->user, $this->xml);//Создаем подпись в xml
            $pdf->signFile($this->completion, $this->xml, $this->result, 215);//Подписываем документ
            $pdf->completionPassport($this->completion);//Создаем паспорт
            $file->completionArchive($this->completion);//Создаем архив
            $file->completionDelete($this->completion);//Удаляем старую папку с подписями
        } catch (\Exception $exception) {
            Log::info('err Completion Tenant Files',[$exception]);
        }
    }
}
