<?php
namespace Henrotaym\LaravelHelpers\Tests\Unit;

use Henrotaym\LaravelHelpers\Tests\TestCase;
use Henrotaym\LaravelHelpers\Facades\Helpers;

class StrContainsTest extends TestCase
{
    /**
     * @test
     */
    public function str_contains_returning_true_if_haystack_contains_needle()
    {
        $this->assertTrue(Helpers::str_contains('xyz', 'y'));
    }

    /**
     * @test
     */
    public function str_contains_returning_false_if_haystack_do_not_contain_needle()
    {
        $this->assertFalse(Helpers::str_contains('xyz', 'a'));
    }
}