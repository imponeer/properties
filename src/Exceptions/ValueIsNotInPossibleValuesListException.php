<?php

declare(strict_types=1);

namespace Imponeer\Properties\Exceptions;

use Exception;
use Throwable;

/**
 * This exception raises when value is not in possible values list
 *
 * @package Imponeer\Properties\Exceptions
 */
class ValueIsNotInPossibleValuesListException extends Exception
{
	public function __construct(
		public readonly string $property,
		int $code = 0,
		?Throwable $previous = null
	)
	{
		parent::__construct(
			sprintf("Value is not in possible values list for property %s!", $property),
			$code,
			$previous
		);
	}

}
