<?php


namespace Amirhosseinabd\LaravelEasySearch\Eloquent\Traits;

use Amirhosseinabd\LaravelEasySearch\Concerns\SearchOptions;
use Amirhosseinabd\LaravelEasySearch\Eloquent\Factory;
use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function scopeSearch(Builder $query, array $inputs, SearchOptions $searchOptions)
    {
        return (new Factory($query))->search($inputs, $searchOptions);
    }

    public function scopeOrSearch(Builder $query, array $inputs, SearchOptions $searchOptions)
    {
        return $query->union((new Factory($this->query()))->search($inputs, $searchOptions));
    }
}
