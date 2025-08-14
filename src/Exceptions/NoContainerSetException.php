<?php

declare(strict_types=1);

namespace Imponeer\Properties\Exceptions;

use RuntimeException;
use Throwable;

/**
 * Exception thrown when trying to use Properties without setting a container first.
 */
class NoContainerSetException extends RuntimeException
{

    public function __construct(
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct(
			'No container has been set. Call Properties::setContainer() first.',
			$code,
			$previous
		);
    }
}
