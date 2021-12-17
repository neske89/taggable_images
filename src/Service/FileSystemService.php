<?php


namespace App\Service;


use Symfony\Component\Filesystem\Filesystem;

class FileSystemService
{

    private Filesystem $filesystem;
    /**
     * FileSystemService constructor.
     */
    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }
    public function ensureDirectoryExists($path):void {
        $dirPath = pathinfo($path, PATHINFO_DIRNAME);
        $this->filesystem->mkdir($dirPath);
    }

    //ToDo: handle better
    public function rootPath():string {
        return ROOT_DIR;
    }

    public function publicPath(): string {
        $path = $this->rootPath();
        return "{$path}/public";
    }
    public function storagePath(): string {
        $path = $this->publicPath();
        return "{$path}/storage";
    }
}