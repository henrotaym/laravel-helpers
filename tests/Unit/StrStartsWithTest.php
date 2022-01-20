<?php
namespace Henrotaym\LaravelHelpers\Tests\Unit;

use Henrotaym\LaravelHelpers\Tests\Unit\Abstracts\HelpersTestCase;

class StrStartsWithTest extends HelpersTestCase
{
    /** @test */
    public function str_starts_with_returning_false_if_string_not_starting_with_expected_value()
    {
        $this->assertFalse($this->helpers->str_starts_with('test', 'tast'));
    }

    /** @test */
    public function str_starts_with_returning_true_if_string_starting_with_expected_value()
    {
        $this->assertTrue($this->helpers->str_starts_with('testastos', 'test'));
    }
}