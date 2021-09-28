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
