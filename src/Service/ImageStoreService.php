<?php


namespace App\Service;

use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;

abstract class ImageStoreService implements ImageServiceInterface
{
    public static string $directory = 'images';

    private string $imagesDir;

    private SluggerInterface $slugger;
    protected FileSystemService $filesystemService;

    /**
     * ImageService constructor.
     */
    public function __construct()
    {
        $this->slugger = new AsciiSlugger();
        $this->filesystemService = new FileSystemService();
        $dir = self::$directory;
        $this->imagesDir = $this->filesystemService->uploadsPath() . '/' .$dir;
    }

    private function name(string $filePath): string
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $filename = pathinfo($filePath, PATHINFO_FILENAME);
        return $this->slugger->slug($filename) . '-' . uniqid('image_', true) . '.' . $extension;
    }

    private function path(string $provider, string $name): string
    {
        return "$this->imagesDir/$provider/$name";
    }

    public function store(string $provider, string $filePath):string {
        $imageFileName = $this->name($filePath);
        $imageFilePath = $this->path($provider,$imageFileName);
        $this->filesystemService->ensureDirectoryExists($imageFilePath);
        $this->storeToFile($imageFilePath);
        return $imageFilePath;
    }


    abstract public function storeToFile($path):void;


}