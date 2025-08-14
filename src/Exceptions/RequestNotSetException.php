<?php

declare(strict_types=1);

namespace Imponeer\Properties\Exceptions;

use RuntimeException;
use Throwable;

/**
 * Exception that is thrown when trying to access a request that hasn't been set
 * and is not available in the container.
 */
class RequestNotSetException extends RuntimeException
{

    public function __construct(
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct(
			'No PSR-7 request has been set. Call setRequest() or ensure a ServerRequestInterface is available in the container.',
			$code,
			$previous
		);
    }
}
