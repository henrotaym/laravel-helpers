<?php
namespace Henrotaym\LaravelHelpers;

use Throwable;
use Illuminate\Support\Optional;

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
    public function optional(object $element, ...$nested_properties)
    {
        foreach ($nested_properties as $nested_property):
            $element = $this->nestedNullable($element, $nested_property);
            // Break first time we can't nest anymore.
            if (!isset($element)):
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
        // If we try to launch a nested method with specific arguments
        // We call recursively this function and we should automatically match method case.
        if (is_array($property)):
            foreach ($property as $method => $args):
                return $this->nestedNullable($element, $method, ...$args);
            endforeach;
        endif;
        // Method case
        if (method_exists($element, $property)):
            return call_user_func_array([$element, $property], $args);
        endif;
        // Property case
        if (property_exists($element, $property)):
            return $element->$property;
        endif;

        return null;
    }
}