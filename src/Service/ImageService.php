<?php


namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class ImageService
{

     /**
      * ImageService constructor.
      */
     public function __construct(private FileSystemService $fsService,private RequestStack $requestStack,private string $projectURL)
     {

     }
     public function url(string $provider,string $filename):string {
        $imagesPath = ImageStoreService::$directory;
         return "{$this->projectURL}/{$this->fsService->uploadsPath(true)}/{$imagesPath}/{$provider}/{$filename}";
     }
 }