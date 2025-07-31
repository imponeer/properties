<?php

declare(strict_types=1);

namespace Imponeer\Properties\DeprecatedTypes;


use Imponeer\Properties\Types\StringType;

/**
 * @deprecated
 */
class TxtboxType extends StringType
{
    public int $maxLength = 255;
    public bool $autoFormatingDisabled = true;
}