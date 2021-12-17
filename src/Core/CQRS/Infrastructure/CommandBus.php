<?php


namespace App\Core\CQRS\Infrastructure;


use App\Core\CQRS\Domain\Command;
use App\Core\CQRS\Domain\CommandBus as DomainCommandBus;
use Symfony\Component\Messenger\MessageBusInterface;

final class CommandBus implements DomainCommandBus
{
    public function __construct(private MessageBusInterface $commandMessageBus) {}
    public function dispatch(Command $command): void
    {
        $this->commandMessageBus->dispatch($command);
    }
}