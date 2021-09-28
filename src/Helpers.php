<?php
namespace Henrotaym\LaravelHelpers;

use Throwable;

class Helpers
{
    /**
     * Trying to execute given callback with given args.
     * 
     * @param callable $callback function to try.
     * @param mixed $args arguments to give to callback.
     * @return array First element is error (if any), second is response(if no error).
     */
    public function try(callable $callback, ...$args): array
    {
        try {
            return [null, call_user_func_array($callback, $args)];
        } catch (\Throwable $th) {
            return [$th, null];
        }
    }
}