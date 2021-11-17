<?php
namespace Henrotaym\LaravelHelpers\Providers;

use Henrotaym\LaravelHelpers\Helpers;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Helpers::$prefix, function($app) {
            return new Helpers();
        });
    }
}