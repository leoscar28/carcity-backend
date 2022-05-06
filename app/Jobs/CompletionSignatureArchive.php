<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Services\CompletionService;
use App\Services\CompletionSignatureService;
use App\Services\UserService;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use setasign\Fpdi\Fpdi;
use Smalot\PdfParser\Parser;

class CompletionSignatureArchive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected int $completionId;
    protected $xml;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $completionId, $xml)
    {
        $this->completionId =   $completionId;
        $this->xml  =   $xml;
    }

    /**
     * Execute the job.
     *
     * @param CompletionService $completionService
     * @param CompletionSignatureService $completionSignatureService
     * @param UserService $userService
     * @return void
     * @throws Exception
     */
    public function handle(CompletionService $completionService, CompletionSignatureService $completionSignatureService, UserService $userService): void
    {
        if ($completion = $completionService->getById($this->completionId)) {
            $completionSignature   =   $completionSignatureService->getByCompletionId($completion->{MainContract::ID});
            if (sizeof($completionSignature) > 1) {
                $img    =   public_path('img/').'background1.jpg';
                $font   =   public_path('fonts/').'PTSerif-Regular.ttf';
                $user1  =   json_decode($completionSignature[0][MainContract::DATA],true);
                $userDate1  =   $completionSignature[0][MainContract::CREATED_AT];
                $user2  =   json_decode($completionSignature[1][MainContract::DATA],true);
                $userDate2  =   $completionSignature[1][MainContract::CREATED_AT];
                $userData2  =   $userService->getById($completionSignature[1][MainContract::USER_ID]);
                PDF::setPaper('a4')
                    ->loadView('pdfCompletion',compact('img','font','completion','user1','user2','userData2','userDate1','userDate2'))
                    ->save(storage_path('docs/').$completion->{MainContract::CUSTOMER_ID}.'/completions/'.$completion->{MainContract::ID}.'/Паспорт документа.pdf');

                preg_match('~<ds:SignatureValue>([^{]*)</ds:SignatureValue>~i', $this->xml, $match);
                if (array_key_exists(1,$match) && $match[1]) {
                    $file   =   storage_path('docs/').$completion->{MainContract::CUSTOMER_ID}.'/completions/'.$completion->{MainContract::ID}.'/'.$completion->{MainContract::ID}.'-signed.pdf';
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
                    $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
                    $fpdi->useTemplate($template);
                    $fpdi->SetFont("helvetica", 'B', 8);
                    $fpdi->SetTextColor(0,0,0);
                    $top    =   floor($signatures[0][0][5]) - 25;
                    $left   =   215;
                    $name   =   explode(' ',trim($user2['cert']['chain'][0]['subject']['commonName']));
                    $fpdi->Text($left,$top, substr($match[1], 1, 10));
                    $fpdi->Text(($left + 2),($top + 3), substr($match[1], 11, 7).'...');
                    $fpdi->AddFont('HelveticaRegular','','HelveticaRegular.php');
                    $fpdi->SetFont("HelveticaRegular", '', 7);
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
                $root   =   storage_path('docs/').$completion->{MainContract::CUSTOMER_ID}.'/completions/';
                $path   =   $root.$completion->{MainContract::ID}.'.zip';
                $zip    =   new \ZipArchive;
                $zip->open($path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($root.'/'.$completion->{MainContract::ID}.'/'),
                    RecursiveIteratorIterator::LEAVES_ONLY
                );
                foreach ($files as $name => $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($root) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }
                $zip->close();
                Storage::disk('public')->deleteDirectory($completion->{MainContract::CUSTOMER_ID}.'/completions/'.$completion->{MainContract::ID}.'/');
            } else {
                Log::info('error completion size 1 - '.$this->completionId,[$this->completionId]);
            }
        } else {
            Log::info('error completion not found - '.$this->completionId,[$this->completionId]);
        }
    }
}
