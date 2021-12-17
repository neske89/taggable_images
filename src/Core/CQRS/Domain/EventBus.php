<?php

namespace App\Core\Messaging\Domain;

interface EventBus
{
    public function dispatch(Event $event): void;
}