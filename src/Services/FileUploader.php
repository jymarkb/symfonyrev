<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader {

    private string $uploadsDir;

    public function __construct(string $uploadsDir)
    {
        $this->uploadsDir  = $uploadsDir;
    }

    public function uploadFile(UploadedFile $file): string
    {
        $fileName = md5(uniqid()) . '.' . $file->getClientOriginalExtension();

        $file->move($this->uploadsDir, $fileName);

        return $fileName;
    }

    public function getUploadDir(): string
    {
        return $this->uploadsDir;
    }
}


?>