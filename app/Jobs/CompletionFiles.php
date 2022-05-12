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
                $file1  =   storage_path('docs/').$this->completion->{MainContract::CUSTOMER_ID}.'/completions/'.$this->completion->{MainContract::ID}.'/'.$this->completion->{MainContract::ID}.'.pdf';
                $parser = new Parser();
                $pdf = $parser->parseContent(file_get_contents($file));
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
                $num    =   (int) round($signatures[0][0][5]);
                if ($num >= 168) {
                    $top    =   144;
                } else {
                    $top    =   148;
                    //$top    =   $num + 3;
                }
                $left   =   75;
                $fpdi->Text($left,$top, substr($match[1], 1, 10));
                $fpdi->Text(($left + 2),($top + 3), substr($match[1], 11, 7).'...');
                $fpdi->AddFont('HelveticaRegular','','HelveticaRegular.php');
                $fpdi->SetFont("HelveticaRegular", '', 7);
                $name   =   explode(' ',trim($this->result['cert']['chain'][0]['subject']['commonName']));
                $text   =   iconv('utf-8', 'windows-1251', implode(' ',[$name[0],$name[1]]));
                if (sizeof($name) > 2) {
                    $fpdi->Text(($left + 28),$top, $text);
                    if (sizeof($name) === 3) {
                        $text2  =   iconv('utf-8', 'windows-1251', $name[2]);
                    } else {
                        $text2  =   iconv('utf-8', 'windows-1251', implode(' ',[$name[2],$name[3]]));
                    }
                    $fpdi->Text(($left + 28),($top + 3), $text2);
                } else {
                    $fpdi->Text(($left + 28),($top + 2), $text);
                }
                $fpdi->Output($file, 'F');
            }
        } catch (\Exception $exception) {
            Log::info('err Completion Files',[$exception]);
        }
    }
}
