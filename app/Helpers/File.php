<?php

namespace App\Helpers;

use App\Domain\Contracts\MainContract;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class File
{
    const DOMAIN    =   'https://admin.car-city.kz';

    public function completionPath($completion): bool|string
    {
        if ($path = $this->completionFile($completion)) {
            return env(MainContract::APP_URL,self::DOMAIN).'/storage/'.$path;
        }
        return false;
    }

    public function completionFile($completion): bool|string
    {
        $files  =   $this->completionList($completion);
        foreach ($files as &$file) {
            if (Storage::disk(MainContract::PUB)->exists($file)) {
                return $file;
            }
        }
        return false;
    }

    public function completion($completion): bool|string
    {
        if ($completion) {
            if ($completion->{MainContract::FILE}) {
                return $completion->{MainContract::FILE};
            } else if ($path = $this->completionFile($completion)) {
                return base64_encode(Storage::disk(MainContract::PUB)->get($path));
            }
        }
        return false;
    }

    public function completionFolder($completion): void
    {
        $files  =   $this->completionList($completion);
        if (Storage::disk(MainContract::PUB)->exists($files[0])) {
            Storage::disk(MainContract::PUB)->move($files[0], $files[1]);
        }
    }

    public function completionXml($completion, $user, $xml): void
    {
        $path   =   self::completionMainPath($completion);
        Storage::disk(MainContract::PUB)->put($path[1].'Подпись - '.$user->{MainContract::SURNAME}.' '.$user->{MainContract::NAME}.'/'.$user->{MainContract::ID}.'_'.$completion->{MainContract::ID}.'.xml',$xml);
    }

    public function completionCopy($completion): void
    {
        $files  =   $this->completionList($completion);
        Storage::disk(MainContract::PUB)->copy($files[1],$files[2]);
    }

    public static function completionMainPath($completion): array
    {
        $year   =   date('Y',strtotime($completion->date));
        $arr    =   [];
        $arr[0] =   $year.'/completions/'.$completion->{MainContract::CUSTOMER_ID}.'/';
        $arr[1] =   $arr[0].$completion->{MainContract::NUMBER}.'/';
        $arr[2] =   $completion->{MainContract::CUSTOMER_ID}.'/completions/';
        $arr[3] =   $arr[2].$completion->{MainContract::ID}.'/';
        return $arr;
    }

    public static function completionList($completion): array
    {
        $path   =   self::completionMainPath($completion);
        return [
            $path[0].$completion->{MainContract::NUMBER}.'.pdf',
            $path[1].$completion->{MainContract::NUMBER}.'.pdf',
            $path[1].$completion->{MainContract::NUMBER}.'-signed.pdf',
            $path[0].$completion->{MainContract::NUMBER}.'.zip',
            $path[2].$completion->{MainContract::ID}.'.pdf',
            $path[3].$completion->{MainContract::ID}.'.pdf',
            $path[2].$completion->{MainContract::ID}.'.zip',
        ];
    }

    public function completionArchive($completion): void
    {
        $root   =   self::completionMainPath($completion);
        $path   =   storage_path('docs/').$root[0].$completion->{MainContract::NUMBER}.'.zip';
        $zip    =   new \ZipArchive;
        $zip->open($path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(storage_path('docs/').$root[1]),RecursiveIteratorIterator::LEAVES_ONLY);
        foreach ($files as $key => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen(storage_path('docs/').$root[0]) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
    }

    public function completionDelete($completion): void
    {
        $path   =   self::completionMainPath($completion);
        Storage::disk(MainContract::PUB)->deleteDirectory($path[1]);
        Storage::disk(MainContract::PUB)->deleteDirectory($path[3]);

        $list   =   self::completionList($completion);
        Storage::disk(MainContract::PUB)->delete($list[0]);
        Storage::disk(MainContract::PUB)->delete($list[4]);
    }

}
