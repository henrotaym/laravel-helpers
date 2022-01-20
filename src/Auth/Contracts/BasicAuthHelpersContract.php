<?php
namespace Henrotaym\LaravelHelpers\Auth\Contracts;

use Illuminate\Http\Request;
use Henrotaym\LaravelHelpers\Auth\Contracts\BasicAuthCredentialsContract;

/**
 * Representing available methods concerning basic auth.
 */
interface BasicAuthHelpersContract
{
    /**
     * Getting credentials from given request.
     * 
     * @param Request|null $request if Null, current request will be used.
     */
    public function getCredentials(?Request $request = null): ?BasicAuthCredentialsContract;

    /**
     * Getting encoded version of credentials. (usually used as Authorization header.)
     */
    public function encodeCredentials(BasicAuthCredentialsContract $credentials): string;
}