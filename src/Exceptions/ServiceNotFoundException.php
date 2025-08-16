<?php

declare(strict_types=1);

namespace Imponeer\Properties\Exceptions;

use Psr\Container\NotFoundExceptionInterface;
use RuntimeException;

class ServiceNotFoundException extends RuntimeException implements NotFoundExceptionInterface
{
    public function __construct(string $id, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct("Service or class '" . $id . "' not found", $code, $previous);
    }
}
