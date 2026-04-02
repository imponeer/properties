<?php

declare(strict_types=1);

namespace Imponeer\Properties;

use Imponeer\Properties\Enum\DataType;

interface PropertiesInterface
{
    public const DTYPE_STRING = DataType::STRING->value;
    public const DTYPE_INTEGER = DataType::INTEGER->value;
    public const DTYPE_FLOAT = DataType::FLOAT->value;
    public const DTYPE_BOOLEAN = DataType::BOOLEAN->value;
    public const DTYPE_FILE = DataType::FILE->value;
    public const DTYPE_DATETIME = DataType::DATETIME->value;
    public const DTYPE_ARRAY = DataType::ARRAY->value;
    public const DTYPE_LIST = DataType::LIST->value;
    public const DTYPE_OBJECT = DataType::OBJECT->value;
    public const DTYPE_OTHER = DataType::OTHER->value;

    public const DTYPE_DEP_FILE = DataType::DEP_FILE->value;
    public const DTYPE_DEP_TXTBOX = DataType::DEP_TXTBOX->value;
    public const DTYPE_DEP_URL = DataType::DEP_URL->value;
    public const DTYPE_DEP_EMAIL = DataType::DEP_EMAIL->value;
    public const DTYPE_DEP_SOURCE = DataType::DEP_SOURCE->value;
    public const DTYPE_DEP_STIME = DataType::DEP_STIME->value;
    public const DTYPE_DEP_MTIME = DataType::DEP_MTIME->value;
    public const DTYPE_DEP_CURRENCY = DataType::DEP_CURRENCY->value;
    public const DTYPE_DEP_TIME_ONLY = DataType::DEP_TIME_ONLY->value;
    public const DTYPE_DEP_URLLINK = DataType::DEP_URLLINK->value;
    public const DTYPE_DEP_IMAGE = DataType::DEP_IMAGE->value;
    public const DTYPE_DEP_FORM_SECTION = DataType::DEP_FORM_SECTION->value;
    public const DTYPE_DEP_FORM_SECTION_CLOSE = DataType::DEP_FORM_SECTION_CLOSE->value;
}
