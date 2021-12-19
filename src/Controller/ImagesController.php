<?php

namespace App\Controller;

use App\Command\SaveImageCommand;
use App\Core\CQRS\Domain\CommandBus;
use App\Core\CQRS\Domain\QueryBus;
use App\Query\FilterImagesQuery;
use App\Request\FilterImagesRequest;
use App\Request\SaveImageRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/images')]
class ImagesController extends AbstractController
{
    public function __construct(private QueryBus $queryBus, private CommandBus $commandBus)
    {
    }

    #[Route('', name: 'images', methods: ['GET'])]
    public function index(FilterImagesRequest $request): Response
    {
        $query = new FilterImagesQuery($request->getProvider(), $request->getTags(), $request->getPage(), $request->getPageSize());
        $res = $this->queryBus->handle($query);
        return $this->json($res);
    }

    #[Route('', name: 'image-create', methods: ['POST'])]
    public function create(SaveImageRequest $request): Response
    {
        $command = new SaveImageCommand($request->getProvider(), $request->getTags(), $request->getUrl(), $request->getImage());
        $this->commandBus->dispatch($command);
        return $this->json(['result' => 'Image saved.'])->setStatusCode(201);
    }
}
