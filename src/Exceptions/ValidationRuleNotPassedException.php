<?php

declare(strict_types=1);

namespace Imponeer\Properties\Exceptions;

use Exception;

/**
 * This exception is raised when validation fails
 *
 * @package Imponeer\Properties\Exceptions
 */
class ValidationRuleNotPassedException extends Exception
{
    /**
     * Value
     *
     * @var mixed
     */
    protected mixed $value;

    /**
     * ValidationRuleNotPassedException constructor.
     *
     * @param mixed $value Bad value
     * @param int|null $code Int
     * @param Exception|null $previous Previous value
     */
    public function __construct(mixed $value, int $code = 0, ?\Throwable $previous = null) {
        $this->value = $value;
        parent::__construct('Validation rule not passed', $code, $previous);
    }

    /**
     * Get linked value
     *
     * @return mixed
     */
    public function getValue(): mixed {
        return $this->value;
    }

}