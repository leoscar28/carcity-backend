<?php

namespace App\Helpers;

use App\Domain\Contracts\MainContract;
use App\Services\CompletionSignatureService;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\Filter\FilterException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use setasign\Fpdi\PdfReader\PdfReaderException;
use Smalot\PdfParser\Parser;
use Barryvdh\DomPDF\Facade\Pdf as PdfGenerate;

class Pdf
{

    protected UserService $userService;
    protected CompletionSignatureService $completionSignatureService;

    public function __construct(UserService $userService, CompletionSignatureService $completionSignatureService)
    {
        $this->userService  =   $userService;
        $this->completionSignatureService   =   $completionSignatureService;
    }

    /**
     * @throws Exception
     */
    public function parseSignatures($file): array
    {
        $parser =   new Parser();
        $pdf    =   $parser->parseContent(file_get_contents($file));
        $arr    =   [];
        foreach ($pdf->getPages()[0]->getDataTm() as &$value) {
            if (trim($value[1]) === 'подпись') {
                $arr[]   =   $value;
            }
        }
        return $arr;
    }

    /**
     * @throws CrossReferenceException
     * @throws PdfReaderException
     * @throws PdfParserException
     * @throws PdfTypeException
     * @throws FilterException
     */
    public function setSignature($file, $signatures, $match, $result, $left): void
    {

        $num        =   (int) round($signatures[0][0][5]);
        $fpdi       =   new FPDI;
        $fpdi->setSourceFile($file);
        $fpdiTemplate   =   $fpdi->importPage(1);
        $fpdiSize       =   $fpdi->getTemplateSize($fpdiTemplate);
        $fpdi->AddPage($fpdiSize[MainContract::ORIENTATION],[$fpdiSize[MainContract::WIDTH],$fpdiSize[MainContract::HEIGHT]]);
        $fpdi->useTemplate($fpdiTemplate);
        $fpdi->SetFont("helvetica", 'B', 8);
        $fpdi->SetTextColor(0,0,0);

        if ($num >= 168) {
            $top    =   144;
        } else {
            $top    =   149;
        }

        $fpdi->Text($left, $top, substr($match[1],1, 10));
        $fpdi->Text(($left + 2),($top + 3), substr($match[1], 11, 7).'...');

        $fpdi->AddFont('HelveticaRegular','','HelveticaRegular.php');
        $fpdi->SetFont("HelveticaRegular", '', 7);

        $name   =   explode(' ',trim($result['cert']['chain'][0]['subject']['commonName']));
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

    /**
     * @throws CrossReferenceException
     * @throws PdfReaderException
     * @throws PdfParserException
     * @throws FilterException
     * @throws PdfTypeException
     * @throws Exception
     */
    public function signFile($completion, $xml, $result, $left = 75): void
    {
        preg_match('~<ds:SignatureValue>([^{]*)</ds:SignatureValue>~i', $xml, $match);
        if (array_key_exists(1,$match) && $match[1]) {
            $files      =   File::completionList($completion);
            $signatures =   $this->parseSignatures(storage_path('docs/').$files[1]);
            $this->setSignature(storage_path('docs/').$files[2], $signatures, $match, $result, $left);
        }
    }

    public function completionPassport($completion): void
    {
        $path       =   File::completionMainPath($completion);
        $signatures =   $this->completionSignatureService->getByCompletionId($completion->{MainContract::ID});
        if (sizeof($signatures) > 1) {
            $img    =   public_path('img/').'background1.jpg';
            $font   =   public_path('fonts/').'PTSerif-Regular.ttf';
            $user1  =   json_decode($signatures[0][MainContract::DATA],true);
            $userDate1  =   $signatures[0][MainContract::CREATED_AT];
            $user2  =   json_decode($signatures[1][MainContract::DATA],true);
            $userDate2  =   $signatures[1][MainContract::CREATED_AT];
            $userData2  =   $this->userService->getById($signatures[1][MainContract::USER_ID]);
            PdfGenerate::setPaper('a4')
                ->loadView('pdfCompletion',compact('img','font','completion','user1','user2','userData2','userDate1','userDate2'))
                ->save(storage_path('docs/').$path[1].'Паспорт документа.pdf');
        }
    }

}
