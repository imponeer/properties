<?php

declare(strict_types=1);

namespace Imponeer\Properties\Exceptions;

use Exception;

/**
 * This exception is raised when property is locked from modifying
 *
 * @package Imponeer\Properties\Exceptions
 */
class PropertyIsLockedException extends Exception
{
}
