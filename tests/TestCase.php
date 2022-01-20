<?php
namespace Henrotaym\LaravelHelpers\Tests;

use Henrotaym\LaravelTestSuite\TestSuite;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Henrotaym\LaravelHelpers\Providers\HelperServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use TestSuite;
    
    protected function getPackageProviders($app)
    {
        return [
            HelperServiceProvider::class,
        ];
    }
}