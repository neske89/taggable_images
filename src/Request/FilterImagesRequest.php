<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class FilterImagesRequest extends BaseRequest
{
    #[Assert\Type('string')]
    protected ?string $provider;

    #[Assert\Type('array')]
    protected ?array $tags;

    #[Assert\Type('int')]
    protected ?int $page;

    #[Assert\Type('int')]
    protected ?int $pageSize;

    /**
     * @return string
     */
    public function getProvider(): ?string
    {
        return isset($this->provider) ? $this->provider : null;
    }

    /**
     * @return array
     */
    public function getTags(): ?array
    {
        return isset($this->tags) ? $this->tags : null;
    }

    /**
     * @return int
     */
    public function getPage(): ?int
    {
        return isset($this->page) ? $this->page : null;
    }

    /**
     * @return int
     */
    public function getPageSize(): ?int
    {
        return isset($this->pageSize) ? $this->pageSize : null;

    }
}