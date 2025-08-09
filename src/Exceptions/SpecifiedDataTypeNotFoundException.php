<?php

namespace Imponeer\Properties\Exceptions;

use Exception;
use Throwable;

class SpecifiedDataTypeNotFoundException extends Exception
{

    public function __construct(int $dataType, int $code = 0, ?Throwable $previous = null)
	{
		parent::__construct(
			sprintf('Class for data type #%d not found!', $dataType),
			$code,
			$previous
		);
	}
}