<?php


namespace Amirhosseinabd\LaravelEasySearch;

use Amirhosseinabd\LaravelEasySearch\Concerns\SearchOptions;
use Amirhosseinabd\LaravelEasySearch\Concerns\SearcherInterface;

abstract class SearcherProvider
{

    public function search(array $inputs, SearchOptions $searchOptions)
    {
        return $this->make()->search($inputs, $searchOptions);
    }

    abstract protected function make(): SearcherInterface;
}
