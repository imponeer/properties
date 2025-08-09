<?php

/**
 * This file is for binding old Xoops types to new Properties types
 *
 * @deprecated
 */

use Imponeer\Properties\Enum\DataType;

const XOBJ_DTYPE_TXTBOX = DataType::DEP_TXTBOX->value;
const XOBJ_DTYPE_TXTAREA = DataType::STRING->value;
const XOBJ_DTYPE_STRING = DataType::STRING->value;
const XOBJ_DTYPE_INT = DataType::INTEGER->value; // shorthand
const XOBJ_DTYPE_INTEGER = DataType::INTEGER->value;
const XOBJ_DTYPE_URL = DataType::DEP_URL->value;
const XOBJ_DTYPE_EMAIL = DataType::DEP_EMAIL->value;
const XOBJ_DTYPE_ARRAY = DataType::ARRAY->value;
const XOBJ_DTYPE_OTHER = DataType::OTHER->value;
const XOBJ_DTYPE_SOURCE = DataType::DEP_SOURCE->value;
const XOBJ_DTYPE_STIME = DataType::DEP_STIME->value;
const XOBJ_DTYPE_MTIME = DataType::DEP_MTIME->value;
const XOBJ_DTYPE_DATETIME = DataType::DATETIME->value;
const XOBJ_DTYPE_LTIME = DataType::DATETIME->value;
const XOBJ_DTYPE_SIMPLE_ARRAY = DataType::LIST->value;
const XOBJ_DTYPE_CURRENCY = DataType::DEP_CURRENCY->value;
const XOBJ_DTYPE_FLOAT = DataType::FLOAT->value;
const XOBJ_DTYPE_TIME_ONLY = DataType::DEP_TIME_ONLY->value;
const XOBJ_DTYPE_URLLINK = DataType::DEP_URLLINK->value;
const XOBJ_DTYPE_FILE = DataType::DEP_FILE->value;
const XOBJ_DTYPE_IMAGE = DataType::DEP_IMAGE->value;
const XOBJ_DTYPE_FORM_SECTION = DataType::DEP_FORM_SECTION->value;
const XOBJ_DTYPE_FORM_SECTION_CLOSE = DataType::DEP_FORM_SECTION_CLOSE->value;
