<?php

declare(strict_types=1);

namespace Imponeer\Properties\DeprecatedTypes;


use Imponeer\Properties\PropertiesInterface;
use Imponeer\Properties\Types\IntegerType;

/**
 * @deprecated
 */
class UrllinkType extends IntegerType
{
    public bool $autoFormatingDisabled = true;
    public string $validateRule = PropertiesInterface::VALIDATION_RULE_LINKS;
    public string $data_handler = 'link';
}