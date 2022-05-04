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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use SimpleXMLElement;
use Smalot\PdfParser\Parser;

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
            Storage::disk('public')->copy($this->completion->{MainContract::CUSTOMER_ID}.'/completions/'.$this->completion->{MainContract::ID}.'/'.$this->completion->{MainContract::ID}.'.pdf',$this->completion->{MainContract::CUSTOMER_ID}.'/completions/'.$this->completion->{MainContract::ID}.'/'.$this->completion->{MainContract::ID}.'-signed.pdf');
            Storage::disk('public')->put($this->completion->{MainContract::CUSTOMER_ID}.'/completions/'.$this->completion->{MainContract::ID}.'/Подпись 1 - '.$this->user->{MainContract::SURNAME}.' '.$this->user->{MainContract::NAME}.'/'.$this->user->{MainContract::ID}.'_'.$this->completion->{MainContract::ID}.'.xml', $this->xml);
            preg_match('~<ds:SignatureValue>([^{]*)</ds:SignatureValue>~i', $this->xml, $match);
            if (array_key_exists(1,$match) && $match[1]) {
                $file   =   storage_path('docs/').$this->completion->{MainContract::CUSTOMER_ID}.'/completions/'.$this->completion->{MainContract::ID}.'/'.$this->completion->{MainContract::ID}.'-signed.pdf';
                $parser = new Parser();
                $pdf = $parser->parseFile($file);
                $signatures =   [];
                foreach ($pdf->getPages()[0]->getDataTm() as &$value) {
                    if (trim($value[1]) === 'подпись') {
                        $signatures[]   =   $value;
                    }
                }
                $fpdi = new FPDI;
                $count = $fpdi->setSourceFile($file);
                $template   = $fpdi->importPage(1);
                $size       = $fpdi->getTemplateSize($template);
                $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $fpdi->useTemplate($template);
                $fpdi->SetFont("helvetica", 'B', 8);
                $fpdi->SetTextColor(0,0,0);
                $top    =   (ceil($signatures[0][0][5]) + 6);
                Log::info('top',[]);
                $fpdi->Text(75,$top, substr($match[1], 1, 10));
                $fpdi->Text(77,($top + 3), substr($match[1], 11, 7).'...');
                $fpdi->Output($file, 'F');
            }
        } catch (\Exception $exception) {
            Log::info('err Completion Files',[$exception]);
        }
    }
}
