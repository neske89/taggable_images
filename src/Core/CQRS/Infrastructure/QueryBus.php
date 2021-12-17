<?php


namespace App\Core\CQRS\Infrastructure;

use App\Core\CQRS\Domain\Query;
use App\Core\CQRS\Domain\QueryBus as DomainQueryBus;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class QueryBus implements DomainQueryBus
{
    use HandleTrait {
        handle as handleQuery;
    }


    public function __construct(private MessageBusInterface $queryMessageBus)
    {
    }

    public function handle(Query $query): mixed
    {
        return $this->handleQuery($query);
    }


}