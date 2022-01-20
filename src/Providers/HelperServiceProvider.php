<?php
namespace Henrotaym\LaravelHelpers\Providers;

use Henrotaym\LaravelHelpers\Helpers;
use Illuminate\Support\ServiceProvider;
use Henrotaym\LaravelHelpers\Auth\BasicAuthHelpers;
use Henrotaym\LaravelHelpers\Contracts\HelpersContract;
use Henrotaym\LaravelHelpers\Auth\Contracts\BasicAuthHelpersContract;

class HelperServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(BasicAuthHelpersContract::class, BasicAuthHelpers::class);
        
        $this->app->bind(Helpers::$prefix, function($app) {
            return $app->make(Helpers::class);
        });
        $this->app->bind(HelpersContract::class, Helpers::$prefix);
    }
}