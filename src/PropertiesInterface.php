<?php

declare(strict_types=1);

namespace Imponeer\Properties;

use Imponeer\Properties\Enum\DataType;

interface PropertiesInterface
{
    public const int DTYPE_STRING = DataType::STRING->value;
    public const int DTYPE_INTEGER = DataType::INTEGER->value;
    public const int DTYPE_FLOAT = DataType::FLOAT->value;
    public const int DTYPE_BOOLEAN = DataType::BOOLEAN->value;
    public const int DTYPE_FILE = DataType::FILE->value;
    public const int DTYPE_DATETIME = DataType::DATETIME->value;
    public const int DTYPE_ARRAY = DataType::ARRAY->value;
    public const int DTYPE_LIST = DataType::LIST->value;
    public const int DTYPE_OBJECT = DataType::OBJECT->value;
    public const int DTYPE_OTHER = DataType::OTHER->value;
}
