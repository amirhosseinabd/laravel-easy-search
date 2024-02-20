<?php


namespace Amirhosseinabd\LaravelEasySearch\Eloquent;


use Amirhosseinabd\LaravelEasySearch\SearcherProvider;
use Illuminate\Database\Eloquent\Builder;
use Amirhosseinabd\LaravelEasySearch\Concerns\SearcherInterface;

class Factory extends SearcherProvider
{

    private Builder $builder;

    /**
     * EloquentSearcher constructor.
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    protected function make(): SearcherInterface
    {
        return new Searcher($this->builder);
    }
}
