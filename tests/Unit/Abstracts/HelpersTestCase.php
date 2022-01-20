<?php
namespace Henrotaym\LaravelHelpers\Tests\Unit\Abstracts;

use Henrotaym\LaravelHelpers\Helpers;
use Henrotaym\LaravelHelpers\Tests\TestCase;
use Henrotaym\LaravelHelpers\Contracts\HelpersContract;

abstract class HelpersTestCase extends TestCase
{
    /**
     * Available helpers.
     * @var Helpers
     */
    protected $helpers;

    /**
     * Setup related tests.
     * 
     * @return void
     */
    public function setup(): void
    {
        parent::setup();
        $this->setHelpers();
    }

    /**
     * Setting helpers.
     * 
     * @return self
     */
    protected function setHelpers(): self
    {
        $this->helpers = $this->app->make(HelpersContract::class);

        return $this;
    }
}