<?php


namespace App\Query;


use App\Core\CQRS\Domain\Query;

class FilterImagesQuery implements Query
{
    private ?string $provider;

    /**
     * @return string|null
     */
    public function getProvider(): ?string
    {
        return $this->provider;
    }

    /**
     * @return array|null
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * @return int|null
     */
    public function getPage(): ?int
    {
        return $this->page;
    }

    /**
     * @return int|null
     */
    public function getPageSize(): ?int
    {
        return $this->pageSize;
    }
    private ?array $tags;
    private ?int $page;
    private ?int $pageSize;

    /**
     * FilterImagesQuery constructor.
     * @param string|null $provider
     * @param array|null $tags
     * @param int|null $page
     * @param int|null $pageSize
     */
    public function __construct(?string $provider, ?array $tags, ?int $page, ?int $pageSize)
    {
        $this->provider = $provider;
        $this->tags = $tags;
        $this->page = $page;
        $this->pageSize = $pageSize;
    }

}