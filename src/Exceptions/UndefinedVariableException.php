<?php

namespace Imponeer\Properties\Exceptions;

use Exception;
use Throwable;

class UndefinedVariableException extends Exception
{

	public function __construct(string $variable, int $code = 0, ?Throwable $previous = null)
	{
		parent::__construct(
			sprintf(
				'%s is undefined!',
				$variable
			),
			$code,
			$previous
		);
	}

}