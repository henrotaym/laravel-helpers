<?php
namespace Henrotaym\LaravelHelpers\Tests\Unit;

use Henrotaym\LaravelHelpers\Facades\Helpers;
use Henrotaym\LaravelHelpers\Tests\Unit\Abstracts\HelpersTestCase;

class GetDirectoryTest extends HelpersTestCase
{
    /**
     * @test
     */
    public function get_directory_returning_null_if_not_a_class()
    {
        $this->assertNull($this->helpers->getDirectory('test'));
    }

    /**
     * @test
     */
    public function get_directory_returning_directory_for_correct_class()
    {
        $this->assertEquals(__DIR__, $this->helpers->getDirectory(self::class));
    }
}