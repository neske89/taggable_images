<?php


namespace App\Core\CQRS\Domain;


interface CommandBus
{
    public function dispatch(Command $command):void;
}