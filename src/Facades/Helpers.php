<?php
namespace Henrotaym\LaravelHelpers\Facades;

use Illuminate\Support\Facades\Facade;

class Helpers extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'henrotaym_helpers';
    }
}