<?php
declare(strict_types=1);

namespace Imponeer\Properties\Exceptions;

use Exception;
use Throwable;

class SpecifiedDataTypeNotFoundException extends Exception
{
    public function __construct(public readonly int $dataType, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            sprintf('Class for data type #%d not found!', $this->dataType),
            $code,
            $previous
        );
    }
}
