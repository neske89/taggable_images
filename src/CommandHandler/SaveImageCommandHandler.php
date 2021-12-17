<?php


namespace App\CommandHandler;


use App\Command\SaveImageCommand;
use App\Core\CQRS\Domain\CommandHandler;
use App\Repository\ImageRepository;
use App\Service\DownloadImageService;
use App\Service\ImageServiceInterface;
use App\Service\UploadImageService;

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

        $filePath = null;
        if ($command->getUrl() !== null) {

            $this->imageService = new DownloadImageService($command->getUrl());
            $filePath = $command->getUrl();
        }
        else if ($command->getImage() !== null) {
            $this->imageService = new UploadImageService($command->getImage());
            $filePath = $command->getImage()->getClientOriginalName();
        }
        $imageFilePath = $this->imageService->save($command->getProvider(),$filePath);

        dd($imageFilePath);


    }
}