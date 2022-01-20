<?php
namespace Henrotaym\LaravelHelpers\Tests\Unit;

use Henrotaym\LaravelHelpers\Tests\Unit\Abstracts\HelpersTestCase;
use Henrotaym\LaravelHelpers\Auth\Contracts\BasicAuthHelpersContract;

class BasicAuthTest extends HelpersTestCase
{
    /** @test */
    public function helpers_can_get_basic_auth()
    {
        $this->assertInstanceOf(BasicAuthHelpersContract::class, $this->helpers->basicAuth());
    }
}