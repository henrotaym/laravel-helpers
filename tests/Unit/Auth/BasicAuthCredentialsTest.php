<?php
namespace Henrotaym\LaravelHelpers\Tests\Unit\Auth;

use Henrotaym\LaravelHelpers\Tests\TestCase;
use Henrotaym\LaravelHelpers\Auth\BasicAuthCredentials;

/**
 * Tests concerning BasicAuthCredentials.
 * 
 * @see BasicAuthCredentials
 */
class BasicCredentialsTest extends TestCase
{
    /** 
     * Setting up tests.
     * 
     * @return void
     */
    public function setup(): void
    {
        parent::setup();
        $this->setCredentials();
    }

    /** @test */
    public function basic_auth_credentials_instanciating_properly()
    {
        $this->assertEquals($this->username, $this->getPrivateProperty('username', $this->credentials));
        $this->assertEquals($this->password, $this->getPrivateProperty('password', $this->credentials));
    }

    /** @test */
    public function basic_auth_credentials_getting_password()
    {
        $this->assertEquals($this->password, $this->credentials->getPassword());
    }

    /** @test */
    public function basic_auth_credentials_getting_username()
    {
        $this->assertEquals($this->username, $this->credentials->getUsername());
    }
    
    /** @var string */
    protected $username = "username";

    /** @var string */
    protected $password = "password";

    /** @var BasicAuthCredentials */
    protected $credentials;

    /**
     * Setting credentials
     * 
     * @return self
     */
    protected function setCredentials(): self
    {
        $this->credentials = new BasicAuthCredentials($this->username, $this->password);

        return $this;
    }
}