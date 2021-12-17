<?php

namespace App\Controller;

use App\Command\SaveImageCommand;
use App\Core\CQRS\Domain\CommandBus;
use App\Core\CQRS\Domain\QueryBus;
use App\Request\SaveImageRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/images')]
class ImagesController extends AbstractController
{
    public function __construct(private QueryBus $queryBus, private CommandBus $commandBus){}

    #[Route('', name: 'images',methods: ['GET'])]
    public function index(Request $request): Response
    {
        return $this->json(['ratatira'=>$request]);
    }

    #[Route('', name: 'image-create',methods:['POST'])]
    public function create(SaveImageRequest $request): Response
    {
        $command = new SaveImageCommand($request->getProvider(),$request->getTags(),$request->getUrl(),$request->getImage());
        $this->commandBus->dispatch($command);
        return $this->json(['result'=> 'Image saved.'])->setStatusCode(201);
    }
}
