<?php
namespace Henrotaym\LaravelHelpers\Tests\Unit;

use Henrotaym\LaravelHelpers\Tests\TestCase;
use Henrotaym\LaravelHelpers\Facades\Helpers;

class UuidTest extends TestCase
{
    /**
     * @test
     */
    public function uuid_returning_with_dashes()
    {
        $uuid = Helpers::uuid(true);
        
        $this->assertTrue(Helpers::str_contains($uuid, '-'));
    }

    /**
     * @test
     */
    public function uuid_returning_without_dashes()
    {
        $uuid = Helpers::uuid();
        
        $this->assertFalse(Helpers::str_contains($uuid, '-'));
    }
}