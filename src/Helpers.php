<?php
namespace Henrotaym\LaravelHelpers;

use Throwable;
use Illuminate\Support\Optional;
use Illuminate\Contracts\Queue\Job;

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
}