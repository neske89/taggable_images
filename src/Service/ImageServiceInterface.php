<?php


namespace App\Service;


interface ImageServiceInterface
{
    public function storeToFile($path): void;
}