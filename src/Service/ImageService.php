<?php


namespace App\Service;

use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;

abstract class ImageService implements ImageServiceInterface
{
    public const directory = 'images';

    private string $imagesDir;

    private SluggerInterface $slugger;
    private FileSystemService $filesystemService;

    /**
     * ImageService constructor.
     */
    public function __construct()
    {
        $this->slugger = new AsciiSlugger();
        $this->filesystemService = new FileSystemService();
        $this->imagesDir = $this->filesystemService->storagePath() . '/images';
    }

    private function name(string $filePath): string
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $filename = pathinfo($filePath, PATHINFO_FILENAME);
        return $this->slugger->slug($filename) . '-' . uniqid('image', true) . '.' . $extension;
    }

    private function path(string $provider, string $name): string
    {
        return "$this->imagesDir/$provider/$name";
    }

    public function save(string $provider, string $filePath):string {
        $imageFileName = $this->name($filePath);
        $imageFilePath = $this->path($provider,$imageFileName);
        $this->filesystemService->ensureDirectoryExists($imageFilePath);
        $this->saveToFile($imageFilePath);
        return $imageFilePath;
    }

    abstract public function saveToFile($path):void;


}