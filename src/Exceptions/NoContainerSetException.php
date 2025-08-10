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
    /**
     * Create a new exception instance.
     *
     * @param string $message The error message
     * @param int $code The error code
     * @param Throwable|null $previous The previous exception
     */
    public function __construct(
        string $message = 'No container has been set. Call Properties::setContainer() first.',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
