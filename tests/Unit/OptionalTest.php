<?php
namespace Henrotaym\LaravelHelpers\Tests\Unit;

use stdClass;
use Henrotaym\LaravelHelpers\Tests\TestCase;
use Henrotaym\LaravelHelpers\Tests\Unit\Models\Nesting;
use Henrotaym\LaravelHelpers\Facades\Helpers;

class OptionalTest extends TestCase
{
    /**
     * @test
     */
    public function optional_nested_working_with_nested_properties()
    {
        $nesting = new stdClass;
        $nested_first = new stdClass;
        $nested_second = new stdClass;
        $nested_second->name = "Francis";
        $nested_first->second = $nested_second;
        $nesting->first = $nested_first;
        
        $this->assertEquals($nested_second->name, Helpers::optional($nesting, 'first', 'second')->name);
    }

    /**
     * @test
     */
    public function optional_nested_returning_null_for_undefined_property()
    {
        $nesting = new stdClass;
        $nested_first = new stdClass;
        $nesting->first = $nested_first;
        
        $this->assertNull(Helpers::optional($nesting, 'first', 'second', 'third', 'fourth')->name);
    }

    /**
     * @test
     */
    public function optional_nested_working_with_nested_methods_without_parameters()
    {
        $nesting = new Nesting;
        $this->assertEquals("Francis", Helpers::optional($nesting, 'nestedFirst', 'nestedSecond')->name);
    }

    /**
     * @test
     */
    public function optional_nested_working_with_nested_methods_with_parameters()
    {
        $nesting = new Nesting;
        $this->assertEquals("Benoit", Helpers::optional($nesting, 'nestedFirst', ['nestedSecond' => ['Benoit']])->name);
    }

    /**
     * @test
     */
    public function optional_nested_working_with_undefined_nested_methods_with_parameter()
    {
        $nesting = new Nesting;
        $this->assertNull(Helpers::optional($nesting, 'nestedFirst', ['nestedThird' => ['yolo']])->name);
    }

    /**
     * @test
     */
    public function optional_nested_working_with_mixed_arguments()
    {
        $nesting = new Nesting;
        $test = new stdClass;
        $test->nesting = $nesting;
        $this->assertEquals("Benoit", Helpers::optional($test, 'nesting', 'nestedFirst', ['nestedSecond' => ['Benoit']])->name);
    }
}