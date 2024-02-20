<?php


namespace Amirhosseinabd\LaravelEasySearch\Concerns;

interface SearcherInterface
{
    public function search(array $inputs, SearchOptions $searchOptions);
}
