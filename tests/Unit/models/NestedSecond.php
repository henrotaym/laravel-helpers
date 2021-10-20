<?php
namespace Henrotaym\LaravelHelpers\Tests\Unit\Models;

class NestedSecond {
    public $name;

    public function __construct(string $name = "Francis") {
        $this->name = $name;
    }
}