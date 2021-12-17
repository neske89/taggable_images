<?php


namespace App\Core\CQRS\Infrastructure;



use App\Core\Messaging\Domain\Event;
use App\Core\Messaging\Domain\EventBus as DomainEventBus;
use Symfony\Component\Messenger\MessageBusInterface;

class EventBus implements DomainEventBus
{

    public function __construct(private MessageBusInterface $eventMessageBus) {}

    public function dispatch(Event $event): void
    {
        $this->eventMessageBus->dispatch($event);
    }
}