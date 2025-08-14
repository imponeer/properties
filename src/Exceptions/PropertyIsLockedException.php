<?php

declare(strict_types=1);

namespace Imponeer\Properties\Exceptions;

use Exception;
use Throwable;

/**
 * This exception is raised when property is locked from modifying
 *
 * @package Imponeer\Properties\Exceptions
 */
class PropertyIsLockedException extends Exception
{

	public function __construct(
		public readonly string $property,
		int $code = 0,
		?Throwable $previous = null
	)
	{
		parent::__construct(
			sprintf("Property %s is locked!", $property),
			$code,
			$previous
		);
	}

}
