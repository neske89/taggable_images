<?php


namespace App\DTO;


class FilteredImageDTO
{
    public string $url;
    public string $provider;
    public ?int $hits;
    public array $tags;

    /**
     * FilteredImageDTO constructor.
     * @param string $url
     * @param string $provider
     * @param string $tags
     */
    public function __construct(string $url, string $provider, string $tags, ?int $hits)
    {
        $this->url = $url;
        $this->provider = $provider;
        $this->hits = $hits;
        $tagsArray = explode('  ', $tags);
        foreach ($tagsArray as $tag) {
            $this->tags[] = trim($tag);
        }
    }
}