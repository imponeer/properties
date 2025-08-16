<?php
declare(strict_types=1);

namespace Imponeer\Properties\Exceptions;

use Exception;
use Throwable;

class CommonDataTypeNotFoundException extends Exception
{
    public function __construct(public readonly string $varType, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            sprintf('Class for data type "%s" not found!', $this->varType),
            $code,
            $previous
        );
    }
}
