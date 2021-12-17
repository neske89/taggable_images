<?php


namespace App\Command;


use App\Core\CQRS\Domain\Command;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SaveImageCommand implements Command
{
    private string $provider;
    private array $tags;
    private ?string $url;
    private ?UploadedFile $image;

    /**
     * SaveImageCommand constructor.
     * @param string $provider
     * @param array $tags
     * @param string|null $url
     * @param UploadedFile|null $image
     */
    public function __construct(string $provider, array $tags, ?string $url = null, ?UploadedFile $image = null)
    {
        $this->provider = $provider;
        $this->tags = $tags;
        $this->url = $url;
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getProvider(): string
    {
        return $this->provider;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return isset($this->url) ? $this->url : null;
    }

    /**
     * @return UploadedFile|null
     */
    public function getImage(): ?UploadedFile
    {
        return isset($this->image) ? $this->image : null;
    }



}