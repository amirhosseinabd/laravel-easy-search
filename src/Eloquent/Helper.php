<?php


namespace Amirhosseinabd\LaravelEasySearch\Eloquent;


use Amirhosseinabd\LaravelEasySearch\Concerns\SearchOptions;
use Amirhosseinabd\LaravelEasySearch\SearchHelper;
use Illuminate\Database\Eloquent\Builder;

class Helper
{
    public static function singleSearch(Builder $builder, array $inputs, SearchOptions $searchOptions): Builder
    {
        $isFirst = true;
        foreach ($searchOptions->columns() as $column) {
            if ($isFirst) {
                $builder = static::getWhereBuilder($builder, $inputs, $searchOptions->inputName(), $column, SearchHelper::isExact($searchOptions, $column));
                $isFirst = false;
                continue;
            }

            $builder = static::getWhereBuilder($builder, $inputs, $searchOptions->inputName(), $column, SearchHelper::isExact($searchOptions, $column), true);
        }

        return $builder;
    }

    public static function multipleSearch(Builder $builder, array $inputs, SearchOptions $searchOptions): Builder
    {
        foreach ($searchOptions->columns() as $column) {
            $inputName = SearchHelper::getMultipleInputName($searchOptions->inputNames(), $column);
            $builder = static::getWhereBuilder($builder, $inputs, $inputName, $column, SearchHelper::isExact($searchOptions, $column));
        }

        return $builder;
    }

    private static function getWhereBuilder(Builder $builder, array $inputs, string $inputName, string $columnName, bool $isExact, bool $or = false): Builder
    {
        $operator = static::getWhereOperator($isExact);
        $value = static::getWhereValue($operator, SearchHelper::getSearchValue($inputs, $inputName));

        if ($value) {
            if ($or)
                return $builder->orWhere($columnName, $operator, $value);

            return $builder->where($columnName, $operator, $value);
        }

        return $builder;
    }

    private static function getWhereOperator(bool $isExact): string
    {
        return $isExact ? '=' : 'LIKE';
    }

    private static function getWhereValue(string $operator, string $searchValue): string|null
    {
        if (!$searchValue)
            return null;
        return $operator === 'LIKE' ? "%" . $searchValue . "%" : $searchValue;
    }
}
