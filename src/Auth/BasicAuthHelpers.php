<?php
namespace Henrotaym\LaravelHelpers\Auth;

use Illuminate\Http\Request;
use Henrotaym\LaravelHelpers\Auth\BasicAuthCredentials;
use Henrotaym\LaravelHelpers\Contracts\HelpersContract;
use Henrotaym\LaravelHelpers\Auth\Contracts\BasicAuthHelpersContract;
use Henrotaym\LaravelHelpers\Auth\Contracts\BasicAuthCredentialsContract;

/**
 * Representing available methods concerning basic auth.
 */
class BasicAuthHelpers implements BasicAuthHelpersContract
{
    /**
     * Prefix used to encode & decode.
     * 
     * @var string
     */
    protected $prefix = "Basic ";

    /**
     * Separator used to encode & decode.
     * 
     * @var string
     */
    protected $separator = ":";

    /**
     * Getting credentials from given request.
     * 
     * @param Request|null $request if Null, current request will be used.
     */
    public function getCredentials(?Request $request = null): ?BasicAuthCredentialsContract
    {
        if (!$authorization = ($request ?? request())->header('Authorization')):
            return null;
        endif;

        if (!app()->make(HelpersContract::class)->str_starts_with($authorization, $this->prefix)):
            return null;
        endif;

        $encoded = str_replace($this->prefix, '', $authorization);
        $decoded = base64_decode($encoded, true);
        $credentials = explode($this->separator, $decoded);

        if (count($credentials) !== 2):
            return null;
        endif;

        [$username, $password] = $credentials;

        if (!$username || !$password):
            return null;
        endif;

        return app()->make(BasicAuthCredentials::class, ['password' => $password, 'username' => $username]);
    }

    /**
     * Getting encoded version of credentials. (usually used as Authorization header.)
     */
    public function encodeCredentials(BasicAuthCredentialsContract $credentials): string
    {
        return $this->prefix . base64_encode("{$credentials->getUsername()}{$this->separator}{$credentials->getPassword()}");
    }
}