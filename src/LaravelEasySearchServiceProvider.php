<?php

namespace Amirhosseinabd\LaravelEasySearch;

use Amirhosseinabd\LaravelEasySearch\Console\SearchOptionsMakeCommand;
use Illuminate\Support\ServiceProvider;

class LaravelEasySearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SearchOptionsMakeCommand::class
            ]);
        }
    }
}
