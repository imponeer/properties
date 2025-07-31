<?php

declare(strict_types=1);

namespace Imponeer\Properties\Exceptions;

use Exception;
use Throwable;

/**
 * Exception thrown when file is too big
 *
 * @package Imponeer\Properties\Exceptions
 */
class FileTooBigException extends Exception
{
    /**
     * FileTooBigException constructor.
     *
     * @param string $src Source
     * @param float $maxSize Max file size
     * @param float $currentSize Current file size
     * @param int $code Code
     * @param Throwable|null $previous Previous exception
     */
    public function __construct(
        public readonly string $src,
        public readonly float $maxSize,
        public readonly float $currentSize,
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct('File too big!', $code, $previous);
    }
}
