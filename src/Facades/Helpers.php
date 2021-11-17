<?php
namespace Henrotaym\LaravelHelpers\Facades;

use Henrotaym\LaravelHelpers\Helpers as UnderlyingFacade;
use Illuminate\Support\Facades\Facade;

class Helpers extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UnderlyingFacade::$prefix;
    }
}