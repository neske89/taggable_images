<?php


namespace App\Core\CQRS\Domain;


interface QueryBus
{
    public function handle(Query $query):mixed;
}