<?php
namespace Henrotaym\LaravelHelpers\Contracts;

use Throwable;
use Illuminate\Support\Str;
use Illuminate\Support\Optional;
use Illuminate\Contracts\Queue\Job;
use Henrotaym\LaravelHelpers\Auth\Contracts\BasicAuthHelpersContract;

/**
 * Representing available helpers.
 */
interface HelpersContract
{
    /**
     * Trying to execute given callback with given args.
     * 
     * @param callable $callback function to try.
     * @param mixed $args arguments to give to callback.
     * @return array First element is error (if any), second is response(if no error).
     */
    public function try(callable $callback, ...$args): array;

    /**
     * Trying to access nested property.
     * 
     * @param object $element
     * @param string|array $nested_properties Nested properties. Methods should be like ['method_name' => [$arg1, $arg2]]
     * @return Optional Nullable nested property.
     */
    public function optional(object $element, ...$nested_properties): Optional;

    /**
     * Executing given callback if serialized job is instance of given element.
     * 
     * @param Job $job
     * @param mixed $instance_of Same parameter types as native php instanceof.
     * @param callable $callback It receives job instance as first parameter.
     * @return mixed Callback returned value or null if any error.
     */
    public function doIfJobIsInstanceOf(Job $job, $instance_of, callable $callback);

    /**
     * Creating unique uuid.
     * 
     * @param bool $allow_dash Telling if dashes are allowed in created uuid.
     * @return string
     */
    public function uuid(bool $allow_dash = false): string;
    
    /**
     * Telling if given string contains given substring.
     * 
     * @param string $haystack The string to search in.
     * @param string $needle The string to search for.
     * @return bool
     */
    public function str_contains(string $haystack, string $needle): bool;

    /**
     * Telling if given string starts with given substring.
     * 
     * @param string $haystack The string to search in.
     * @param string $needle The string to search for.
     * @return bool
     */
    public function str_starts_with(string $haystack, string $needle): bool;

    /**
     * Getting available helpers concerning basic auth.
     * 
     * @return BasicAuthHelpersContract
     */
    public function basicAuth(): BasicAuthHelpersContract;
}