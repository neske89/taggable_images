<?php


namespace App\QueryHandler;


use App\Core\CQRS\Domain\QueryHandler;
use App\DTO\FilteredImageDTO;
use App\DTO\FilterImagesResponseDTO;
use App\Query\FilterImagesQuery;
use App\Repository\ImageRepository;
use App\Service\ImageService;
use App\Service\ImageStoreService;

class FilterImagesQueryHandler implements QueryHandler
{

    /**
     * FilterImagesQueryHandler constructor.
     */
    public function __construct(private ImageRepository $imageRepository, private ImageService $imageService)
    {
    }

    public function __invoke(FilterImagesQuery $query): FilterImagesResponseDTO
    {
        $results = $this->imageRepository->filter($query->getProvider(), $query->getTags(), $query->getPage(), $query->getPageSize(),$query->getRelevance());
        $response = new FilterImagesResponseDTO();
        foreach ($results as $image) {
            $url = $this->imageService->url($image['provider'],$image['filename']);
            $response->images[] = new FilteredImageDTO($url,$image['provider'],$image['tags'],$image['hits']);
        }
        return $response;
    }
}