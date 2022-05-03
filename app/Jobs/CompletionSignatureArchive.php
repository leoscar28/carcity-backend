<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Services\CompletionService;
use App\Services\CompletionSignatureService;
use App\Services\UserService;
use Barryvdh\DomPDF\Facade\Pdf;
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

class CompletionSignatureArchive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected int $completionId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $completionId)
    {
        $this->completionId =   $completionId;
    }

    /**
     * Execute the job.
     *
     * @param CompletionService $completionService
     * @param CompletionSignatureService $completionSignatureService
     * @param UserService $userService
     * @return void
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
