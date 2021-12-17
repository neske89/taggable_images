<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadImageService extends ImageService
{


    /**
     * UploadImageService constructor.
     */
    public function __construct(private UploadedFile $source)
    {
        parent::__construct();
    }

    public function saveToFile($destination):void
    {
        $this->filesystemService->copy($this->source->getRealPath(),$destination);
    }

}