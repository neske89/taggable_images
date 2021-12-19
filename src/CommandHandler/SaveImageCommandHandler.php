<?php


namespace App\CommandHandler;


use App\Command\SaveImageCommand;
use App\Core\CQRS\Domain\CommandHandler;
use App\Repository\ImageRepository;
use App\Service\DownloadImageStoreService;
use App\Service\ImageServiceInterface;
use App\Service\UploadImageStoreService;

class SaveImageCommandHandler implements CommandHandler
{
    private ImageServiceInterface $imageService;

    /**
     * SaveImageCommandHandler constructor.
     * @param ImageServiceInterface $imageService
     */
    public function __construct(private ImageRepository $imageRepository)
    {
    }

    public function __invoke(SaveImageCommand $command): void
    {
        $imageFilePath = 'a';
        $id = null;
        try {
            $originFilePath = null;
            if ($command->getUrl() !== null) {

                $this->imageService = new DownloadImageStoreService($command->getUrl());
                $originFilePath = $command->getUrl();
            } else if ($command->getImage() !== null) {
                $this->imageService = new UploadImageStoreService($command->getImage());
                $originFilePath = $command->getImage()->getClientOriginalName();
            }
            $imageFilePath = $this->imageService->save($command->getProvider(), $originFilePath);
            $fileName = pathinfo($imageFilePath,PATHINFO_FILENAME) .'.'. pathinfo($imageFilePath,PATHINFO_EXTENSION);
            $tags = implode('  ',$command->getTags());
            $tags = ' ' . $tags . ' ';
            $id = $this->imageRepository->save($command->getProvider(),$tags,$fileName);
        }
        //delete file if there were any issues
            //ToDo: Provide more specified exceptions
        catch (\Exception $e) {
            if ($imageFilePath && file_exists($imageFilePath)) {
                unlink($imageFilePath);
            }
            //pass exception further to stack
            throw $e;
        }
        finally  {
            //another check if exception has been caught deeper in the stack
            if (!$id) {
                if ($imageFilePath && file_exists($imageFilePath)) {
                    unlink($imageFilePath);
                }
            }
        }
    }
}