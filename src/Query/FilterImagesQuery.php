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


    /**
     * @return bool|null
     */
    public function getRelevance(): ?int
    {
        return $this->relevance;
    }

    private ?array $tags;
    private ?int $page;
    private ?int $pageSize;
    private ?bool $relevance;

    /**
     * FilterImagesQuery constructor.
     * @param string|null $provider
     * @param array|null $tags
     * @param int|null $page
     * @param int|null $pageSize
     */
    public function __construct(?string $provider, ?array $tags, ?int $page, ?int $pageSize,?bool $relevance)
    {
        $this->provider = $provider;
        $this->tags = $tags;
        $this->page = $page;
        $this->pageSize = $pageSize;
        $this->relevance = $relevance;
    }


}