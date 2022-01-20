<?php
namespace Henrotaym\LaravelHelpers\Auth\Contracts;

/**
 * Reprensenting an entity that could be used as basic auth.
 */
interface BasicAuthCredentialsContract
{
    /**
     * Getting username.
     * 
     * @return string
     */
    public function getUsername(): string;

    /**
     * Getting password.
     * 
     * @return string
     */
    public function getPassword(): string;
}