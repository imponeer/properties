<?php

declare(strict_types=1);

namespace Imponeer\Properties\Attribute;

use Attribute;
use Imponeer\Properties\AbstractType;

/**
 * Attribute to link an enum case to a specific type
 */
#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class LinkedCaseType
{
    /**
     * @param class-string<AbstractType> $class
     */
    public function __construct(
        public readonly string $class,
    ) {
    }
}