<?php
namespace Henrotaym\LaravelHelpers\Auth;

use Henrotaym\LaravelHelpers\Auth\Contracts\BasicAuthCredentialsContract;

/**
 * Representing an entity that could be used as basic auth.
 */
class BasicAuthCredentials implements BasicAuthCredentialsContract
{
    /**
     * Instanciating basic credentials.
     * 
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->password = $password;
        $this->username = $username;
    }

    /**
     * Getting username.
     * 
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Getting password.
     * 
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}