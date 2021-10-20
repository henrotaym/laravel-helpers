<?php
namespace Henrotaym\LaravelHelpers\Tests\Unit\Models;

class NestedFirst {
    public function nestedSecond(string $name = "Francis") {
        return new NestedSecond($name);
    }
}