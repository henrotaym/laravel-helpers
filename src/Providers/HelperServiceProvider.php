<?php
namespace Henrotaym\LaravelHelpers\Providers;

use Henrotaym\LaravelHelpers\Helpers;
use Illuminate\Support\ServiceProvider;
use Henrotaym\LaravelHelpers\Contracts\HelpersContract;

class HelperServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Helpers::$prefix, function($app) {
            return new Helpers();
        });

        $this->app->bind(HelpersContract::class, Helpers::$prefix);
    }
}