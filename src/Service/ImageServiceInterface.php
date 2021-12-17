<?php


namespace App\Service;


interface ImageServiceInterface
{
    public function saveToFile($path): void;
}