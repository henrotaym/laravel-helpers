<?php
namespace Henrotaym\LaravelHelpers;

use Throwable;
use Illuminate\Support\Str;
use Illuminate\Support\Optional;
use Illuminate\Contracts\Queue\Job;
use Henrotaym\LaravelHelpers\Contracts\HelpersContract;
use Henrotaym\LaravelHelpers\Auth\Contracts\BasicAuthHelpersContract;

/**
 * Representing available helpers.
 */
class Helpers implements HelpersContract
{

    /**
     * Helpers concerning basic auth.
     * 
     * @var BasicAuthHelpersContract
     */
    protected $basic_auth_helpers;

    /**
     * Injecting dependencies.
     * 
     * @param BasicAuthHelpersContract $basic_auth_helpers
     */
    public function __construct(BasicAuthHelpersContract $basic_auth_helpers)
    {
        $this->basic_auth_helpers = $basic_auth_helpers;
    }

    /**
     * Prefix used by this package.
     * 
     * @var string
     */
    public static $prefix = "henrotaym_helpers";

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

    /**
     * Trying to access nested property.
     * 
     * @param object $element
     * @param string|array $nested_properties Nested properties. Methods should be like ['method_name' => [$arg1, $arg2]]
     * @return Optional Nullable nested property.
     */
    public function optional(object $element, ...$nested_properties): Optional
    {
        foreach ($nested_properties as $nested_property):
            $element = $this->nestedNullable($element, $nested_property);
            // Break first time we can't nest anymore.
            if (!$element):
                break;
            endif;
        endforeach;

        return optional($element);
    }
    
    /**
     * Recursive function used to get nested elements for optional helper.
     * 
     * @param mixed $element
     * @param array|string $property Property or method we're trying to access.
     * @return mixed Nested element or null.
     */
    protected function nestedNullable($element, $property, ...$args)
    {
        $is_method_with_args = is_array($property);
        // If we try to launch a nested method with specific arguments
        // We call recursively this function and we should automatically match method case.
        if ($is_method_with_args):
            foreach ($property as $method => $args):
                return $this->nestedNullable($element, "$method()", ...$args);
            endforeach;
        endif;
        // Method case
        $parenthesis_position = strpos($property, '(');
        if ($parenthesis_position):
            $method_name = substr($property, 0, $parenthesis_position);
            // Accessing undefined methods should return null instead of throwing
            [, $value] = $this->try(function() use ($element, $method_name, $args) {
                return optional($element)->$method_name(...$args);
            });
            return $value;
        endif;
        // Property case
        return optional($element)->$property;
    }

    /**
     * Getting given job instance.
     * 
     * @param Job $job
     * @return mixed Job instance or null if any error.
     */
    protected function getJobInstance(Job $job)
    {
        [, $job_instance] = $this->try(function() use ($job) {
            return unserialize($job->payload()['data']['command']);
        });

        return $job_instance;
    }

    /**
     * Executing given callback if serialized job is instance of given element.
     * 
     * @param Job $job
     * @param mixed $instance_of Same parameter types as native php instanceof.
     * @param callable $callback It receives job instance as first parameter.
     * @return mixed Callback returned value or null if any error.
     */
    public function doIfJobIsInstanceOf(Job $job, $instance_of, callable $callback)
    {
        $instance = $this->getJobInstance($job);
        if (!$instance || !$instance instanceof $instance_of):
            return null;
        endif;
        
        return $callback($instance);
    }

    /**
     * Creating unique uuid.
     * 
     * @param bool $allow_dash Telling if dashes are allowed in created uuid.
     * @return string
     */
    public function uuid(bool $allow_dash = false): string
    {
        $uuid = Str::uuid();
        return $allow_dash
            ? $uuid
            : str_replace('-', '', $uuid); 
    }
    
    /**
     * Telling if given string contains given substring.
     * 
     * @param string $haystack The string to search in.
     * @param string $needle The string to search for.
     * @return bool
     */
    public function str_contains(string $haystack, string $needle): bool
    {
        return strpos($haystack, $needle) !== false;
    }

    /**
     * Telling if given string starts with given substring.
     * 
     * @param string $haystack The string to search in.
     * @param string $needle The string to search for.
     * @return bool
     */
    public function str_starts_with(string $haystack, string $needle): bool
    {
        return strpos($haystack, $needle) === 0;
    }

    /**
     * Getting available helpers concerning basic auth.
     * 
     * @return BasicAuthHelpersContract
     */
    public function basicAuth(): BasicAuthHelpersContract
    {
        return $this->basic_auth_helpers;
    }
}