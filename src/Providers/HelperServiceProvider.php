<?php
namespace Henrotaym\LaravelHelpers\Providers;

use Henrotaym\LaravelHelpers\Helpers;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind("henrotaym_helpers", function($app) {
            return new Helpers();
        });
    }
}