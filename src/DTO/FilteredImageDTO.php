<?php


namespace App\DTO;


class FilteredImageDTO
{
    public string $url;
    public string $provider;
    public array $tags;

    /**
     * FilteredImageDTO constructor.
     * @param string $url
     * @param string $provider
     * @param string $tags
     */
    public function __construct(string $url, string $provider, string $tags)
    {
        $this->url = $url;
        $this->provider = $provider;
        $tagsArray = explode('  ', $tags);
        foreach ($tagsArray as $tag) {
            $this->tags[] = trim($tag);
        }
    }
}