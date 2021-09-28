<?php
namespace Henrotaym\LaravelHelpers\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Henrotaym\LaravelHelpers\Providers\HelperServiceProvider;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            HelperServiceProvider::class,
        ];
    }
}