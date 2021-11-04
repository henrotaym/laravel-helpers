# Laravel helpers

A kit of usefull helpers accessible via a facade.

## Installation

	composer require henrotaym/laravel-helpers

## Access the facade

	use Henrotaym/LaravelHelpers/Facades/Helpers;

## Available methods
### Try

	/**
	* Trying to execute given callback with given args.
	*
	* @param callable $callback function to try.
	* @param mixed $args arguments to give to callback.
	* @return array First element is error (if any), second is response(if no error).
	*/

	public function try(callable $callback, ...$args): array;

### Optional

	/**
     * Trying to access nested property.
     * 
     * @param object $element
     * @param string|array $nested_properties Nested properties. Methods should be like ['method_name' => [$arg1, $arg2]] OR method_name() if it doesn't need arguments.
     * @return Illuminate\Support\Optional Nullable nested property.
     */
    public function optional(object $element, ...$nested_properties): Illuminate\Support\Optional

### doIfJobIsInstanceOf

	/**
     * Executing given callback if serialized job is instance of given element.
     * 
     * @param Job $job
     * @param mixed $instance_of Same parameter types as native php instanceof.
     * @param callable $callback It receives job instance as first parameter.
     * @return mixed Callback returned value or null if any error.
     */
    public function doIfJobIsInstanceOf(Job $job, $instance_of, callable $callback);

