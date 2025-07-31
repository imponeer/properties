<?php

declare(strict_types=1);

namespace Imponeer\Properties\Exceptions;

use Exception;
use Throwable;

/**
 * This exception is raised when validation fails
 *
 * @package Imponeer\Properties\Exceptions
 */
class ValidationRuleNotPassedException extends Exception
{
    /**
     * ValidationRuleNotPassedException constructor.
     *
     * @param mixed $value Bad value
     * @param int $code Int
     * @param Exception|null $previous Previous value
     */
    public function __construct(
        public readonly mixed $value,
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct('Validation rule not passed', $code, $previous);
    }
}
