<?php

namespace App\Jobs;

use App\Domain\Contracts\MainContract;
use App\Services\ApplicationService;
use App\Services\ApplicationSignatureService;
use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ApplicationSignatureArchive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected int $applicationId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $applicationId)
    {
        $this->applicationId    =   $applicationId;
    }

    /**
     * Execute the job.
     *
     * @param ApplicationService $applicationService
     * @param ApplicationSignatureService $applicationSignatureService
     * @param UserService $userService
     * @return void
     */
    public function handle(ApplicationService $applicationService, ApplicationSignatureService $applicationSignatureService, UserService $userService): void
    {
        if ($application = $applicationService->getById($this->applicationId)) {
            $applicationSignature   =   $applicationSignatureService->getByApplicationId($application->{MainContract::ID});
            if (sizeof($applicationSignature) > 1) {
                $img    =   public_path('img/').'background1.jpg';
                $font   =   public_path('fonts/').'PTSerif-Regular.ttf';
                $user1  =   json_decode($applicationSignature[0][MainContract::DATA],true);
                $userDate1  =   $applicationSignature[0][MainContract::CREATED_AT];
                $user2  =   json_decode($applicationSignature[1][MainContract::DATA],true);
                $userDate2  =   $applicationSignature[1][MainContract::CREATED_AT];
                $userData2  =   $userService->getById($applicationSignature[1][MainContract::USER_ID]);
                try {
                    PDF::setPaper('a4')
                        ->loadView('pdf',compact('img','font','application','user1','user2','userData2','userDate1','userDate2'))
                        ->save(storage_path('docs/').$application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'/Паспорт документа.pdf');
                    $root   =   storage_path('docs/').$application->{MainContract::CUSTOMER_ID}.'/applications/';
                    $path   =   $root.$application->{MainContract::ID}.'.zip';
                    $zip    =   new \ZipArchive;
                    $zip->open($path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
                    $files = new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator($root.'/'.$application->{MainContract::ID}.'/'),
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
                    Storage::disk('public')->deleteDirectory($application->{MainContract::CUSTOMER_ID}.'/applications/'.$application->{MainContract::ID}.'/');
                } catch (\Exception $exception) {

                }
            } else {
                Log::info('error application size 1 - '.$this->applicationId,[$this->applicationId]);
            }
        } else {
            Log::info('error application not found - '.$this->applicationId,[$this->applicationId]);
        }
    }
}
