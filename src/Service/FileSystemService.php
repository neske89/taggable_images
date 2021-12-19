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

    public function copy(string $origin,string $destination):void {
        $this->filesystem->copy($origin,$destination);
    }

    //ToDo: handle better
    public function rootPath():string {
        return ROOT_DIR;
    }

    public function publicPath(): string {
        $path = $this->rootPath();
        return "{$path}/public";
    }
    public function uploadsPath($relative = true): string {
        if ($relative) {
            return '/uploads';
        }
        $path = $this->publicPath();
        return "{$path}/uploads";
    }
}