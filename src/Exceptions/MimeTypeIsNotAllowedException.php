<?php

declare(strict_types=1);

namespace Imponeer\Properties\Exceptions;

use Exception;
use Throwable;

/**
 * This exception is throw when mimetype is not allowed
 *
 * @package Imponeer\Properties\Exceptions
 */
class MimeTypeIsNotAllowedException extends Exception
{
    /**
     * MimeTypeIsNotAllowedException constructor.
     * @param string $mimetype Current mimetype
     * @param string[] $allowedMimetypes Allowed mimetypes list
     * @param int $code Code
     * @param Throwable|null $previous Previous exception
     */
    public function __construct(
        public readonly string $mimetype,
        public readonly array $allowedMimetypes,
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct('Mimetype is not allowed', $code, $previous);
    }
}
