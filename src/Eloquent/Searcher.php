<?php


namespace Amirhosseinabd\LaravelEasySearch\Eloquent;

use Amirhosseinabd\LaravelEasySearch\Concerns\MultipleSearchOptions;
use Amirhosseinabd\LaravelEasySearch\Concerns\SearchOptions;
use Amirhosseinabd\LaravelEasySearch\Concerns\SingleSearchOptions;
use Amirhosseinabd\LaravelEasySearch\Concerns\SearcherInterface;
use Amirhosseinabd\LaravelEasySearch\Eloquent\Concerns\WithRelation;
use Amirhosseinabd\LaravelEasySearch\SearchHelper;
use Illuminate\Database\Eloquent\Builder;

class Searcher implements SearcherInterface
{
    private Builder $builder;
    private Builder $relationBuilder;

    /**
     * EloquentSearcher constructor.
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function search(array $inputs, SearchOptions $searchOptions)
    {
        if ($searchOptions instanceof SingleSearchOptions){
            if ($searchOptions instanceof WithRelation)
                return $this->relationalSearch($inputs, $searchOptions);

            if (!SearchHelper::hasSearchValue($inputs, $searchOptions))
                return $this->builder;

            return Helper::singleSearch($this->builder, $inputs, $searchOptions);
        }

        if ($searchOptions instanceof MultipleSearchOptions){
            if ($searchOptions instanceof WithRelation)
                return $this->relationalSearch($inputs, $searchOptions);

            return Helper::multipleSearch($this->builder, $inputs, $searchOptions);
        }

    }

    private function relationalSearch(array $inputs, SearchOptions $searchOptions, bool $isMultiple = false): Builder
    {
        if (!SearchHelper::hasSearchValue($inputs, $searchOptions))
            return $this->builder;

        $model = $this->builder->getModel();
        $this->builder = $model->whereHas($searchOptions->relation(), function ($query) use ($searchOptions, $inputs, $isMultiple) {
            $this->relationBuilder = $query;
            $query = $isMultiple ? Helper::multipleSearch($query, $inputs, $searchOptions) : Helper::singleSearch($query, $inputs, $searchOptions);
            $this->relationBuilder = $query;
        });
        return $this->builder;
    }
}
