<?php


namespace Amirhosseinabd\LaravelEasySearch;


use Amirhosseinabd\LaravelEasySearch\Concerns\MultipleSearchOptions;
use Amirhosseinabd\LaravelEasySearch\Concerns\SearchOptions;
use Amirhosseinabd\LaravelEasySearch\Concerns\SingleSearchOptions;

class SearchHelper
{

    public static function hasSearchValue(array $inputs, SearchOptions $searchOptions): bool
    {
        if ($searchOptions instanceof SingleSearchOptions)
            return (static::getSearchValue($inputs, $searchOptions->inputName()) !== "") && !is_null(static::getSearchValue($inputs, $searchOptions->inputName()));

        if ($searchOptions instanceof MultipleSearchOptions){
            foreach ($searchOptions->columns() as $column) {
                $inputName = static::getMultipleInputName($inputs, $column);
                if (isset($inputs[$inputName]) && (static::getSearchValue($inputName) !== "") && !is_null(static::getSearchValue($inputName))) {
                    return true;
                }
            }
            return false;
        }
    }

    public static function getSearchValue(array $inputs, string $inputName): string
    {
        return $inputs[$inputName] ?? "";
    }

    public static function isExact(SearchOptions $options, $columnName)
    {
        if (method_exists($options, 'exacts')){
            return in_array($columnName, $options->exacts());
        }

        return false;
    }

    public static function getMultipleInputName(array $inputNames, string $column){

        return $inputNames[$column] ?? $column;
    }

}
