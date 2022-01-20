<?php
namespace Henrotaym\LaravelHelpers\Tests\Unit\Auth;

use Illuminate\Http\Request;
use Henrotaym\LaravelHelpers\Tests\TestCase;
use Henrotaym\LaravelHelpers\Auth\BasicAuthCredentials;
use Henrotaym\LaravelHelpers\Contracts\HelpersContract;
use Henrotaym\LaravelHelpers\Auth\Contracts\BasicAuthHelpersContract;
use Henrotaym\LaravelHelpers\Auth\Contracts\BasicAuthCredentialsContract;

/**
 * Tests concerning BasicAuthCredentials.
 * 
 * @see BasicAuthHelpers
 */
class BasicAuthHelpersTest extends TestCase
{
    /** 
     * Setting up tests.
     * 
     * @return void
     */
    public function setup(): void
    {
        parent::setup();
        $this->setAuthHelpers()
            ->mockHelpers()
            ->mockRequest()
            ->setEncoded();
    }

    /** @test */
    public function basic_auth_helpers_get_credentials_returning_null_if_request_without_authorization_header()
    {
        $this->requestHeaderReturning(null);
        $this->assertNull($this->auth_helpers->getCredentials($this->request));
    }

    /** @test */
    public function basic_auth_helpers_get_credentials_returning_null_if_authorization_not_starting_with_expected_prefix()
    {
        $this->requestHeaderReturning($this->encoded)
            ->helpersStartWithReturning(false);

        $this->assertNull($this->auth_helpers->getCredentials($this->request));
    }

    /** @test */
    public function basic_auth_helpers_get_credentials_returning_null_if_authorization_separator_not_present()
    {
        $this->setEncoded('not_present')
            ->requestHeaderReturning($this->encoded)
            ->helpersStartWithReturning(true);

        $this->assertNull($this->auth_helpers->getCredentials($this->request));
    }

    /** @test */
    public function basic_auth_helpers_get_credentials_returning_null_if_authorization_separator_is_last_character()
    {
        $this->setEncoded('last:')
            ->requestHeaderReturning($this->encoded)
            ->helpersStartWithReturning(true);

        $this->assertNull($this->auth_helpers->getCredentials($this->request));
    }

    /** @test */
    public function basic_auth_helpers_get_credentials_returning_null_if_authorization_separator_is_first_character()
    {
        $this->setEncoded(':first')
            ->requestHeaderReturning($this->encoded)
            ->helpersStartWithReturning(true);

        $this->assertNull($this->auth_helpers->getCredentials($this->request));
    }

    /** @test */
    public function basic_auth_helpers_get_credentials_returning_credentials_if_authorization_is_valid()
    {
        $this->requestHeaderReturning($this->encoded)
            ->helpersStartWithReturning(true);

        $this->assertInstanceOf(BasicAuthCredentialsContract::class, $this->auth_helpers->getCredentials($this->request));
    }

    /** @test */
    public function basic_auth_helpers_encoding_credentials_correctly()
    {
        $this->mockCredentials();

        $this->credentials->expects()->getUsername()->andReturn($this->username);
        $this->credentials->expects()->getPassword()->andReturn($this->password);

        $this->assertEquals($this->encoded, $this->auth_helpers->encodeCredentials($this->credentials));
    }

    /**
     * Forcing request header method to return given value.
     * 
     * @param string|null $value
     * @return self
     */
    protected function requestHeaderReturning(?string $value): self
    {
        $this->request->expects()->header('Authorization')->andReturn($value);

        return $this;
    }

    /** @var string */
    protected $username = "username";

    /** @var string */
    protected $password = "password";

    /**
     * Setting encoded value
     * 
     * @param string $value
     * @return self
     */
    protected function setEncoded(string $value = null): self
    {
        $this->encoded = "Basic ". base64_encode($value ?? "$this->username:$this->password");

        return $this;
    }

    /**
     * Forcing helpers str_starts_with method to return given value.
     * 
     * @param bool $value
     * @return self
     */
    protected function helpersStartWithReturning(bool $value): self
    {
        $this->helpers->expects()->str_starts_with()
            ->withArgs(function($encoded) {
                return $encoded === $this->encoded;
            })
            ->andReturn($value);

        return $this;
    }

    /** @var BasicAuthHelpersContract */
    protected $auth_helpers;

    /**
     * Setting auth helpers.
     * 
     * @return self
     */
    protected function setAuthHelpers(): self
    {
        $this->auth_helpers = app()->make(BasicAuthHelpersContract::class);

        return $this;
    }

    /** @var MockInstance */
    protected $request;

    /**
     * Mocking a request.
     * 
     * @return self
     */
    protected function mockRequest(): self
    {
        $this->request = $this->mockThis(Request::class);

        return $this;
    }

    /** @var MockInstance */
    protected $helpers;

    /**
     * Mocking a request.
     * 
     * @return self
     */
    protected function mockHelpers(): self
    {
        $this->helpers = $this->mockThis(HelpersContract::class);

        return $this;
    }

    /** @var MockInstance */
    protected $credentials;

    /**
     * Mocking a request.
     * 
     * @return self
     */
    protected function mockCredentials(): self
    {
        $this->credentials = $this->mockThis(BasicAuthCredentialsContract::class);

        return $this;
    }
}