<?php

declare(strict_types=1);

namespace Imponeer\Properties\DeprecatedTypes;


use Imponeer\Properties\PropertiesInterface;
use Imponeer\Properties\Types\StringType;

/**
 * @deprecated
 */
class EmailType extends StringType
{
    public bool $autoFormatingDisabled = true;
    public string $validateRule = PropertiesInterface::VALIDATION_RULE_EMAIL;
}